<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AuctionCategory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Validator;
use Storage;
class ProductController extends Controller
{
    function addProduct(request $request)
    {
        $data['category'] = AuctionCategory::all();
        return view('product.addProduct', $data);
    }

    function postProduct(request $request)
    {   
        $request->validate([
            'brand' => 'required',
            'title' => 'required',
            'description' => 'required|string',  
            'department' => 'required',     
            'condition' => 'required', 
            'option' => 'required',        
            'original_price' => 'required', 
            'discount_price' => 'required', 
            'discount_percentage' => 'required', 
            'stock' => 'required',  
        ]);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $postFields = [
                'path' =>'storage/product',
                'image' =>  curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
            ];
            $path = $this->postApi('image-upload',$postFields);  
            $request->img = $path['storage_path'];
        }
        
        $department = explode(",",$request->department);
        $option = explode(",",$request->option);
        $product = Product::create([
            'brand' => $request->brand,
            'title' => $request->title,
            'description' => $request->description,
            'img' => $request->img,
            'department' => json_encode($department),
            'condition' => $request->condition,
            'options' => json_encode($option),
            'original_price' => $request->original_price,
            'discount_price' => $request->discount_price,
            'discount_percentage' => $request->discount_percentage,
            'stock' => $request->stock,
            'author' => session('user_data')['id']
        ]);

        return redirect('product-list');

    }

    function productEdit(request $request, $id)
    {
        $data['product'] = Product::findOrFail($id);
        $data['category'] = AuctionCategory::getActiveCategories();
        return view('product.editProduct', $data);

    }

    function updateProduct(request $request, $slug)
    {   
        $request->validate([
            'brand' => 'required',
            'title' => 'required',
            'description' => 'required|string',  
            'department' => 'required',     
            'condition' => 'required', 
            'option' => 'required',        
            'original_price' => 'required', 
            'discount_price' => 'required', 
            'discount_percentage' => 'required', 
            'stock' => 'required',  
        ]);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $postFields = [
                'path' =>'storage/product',
                'image' =>  curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
            ]  ;
            $path = $this->postApi('image-upload',$postFields);  
            $request->img = $path['storage_path'];
        }
        $product = Product::firstOrFail('id',$slug);
        if (!$product) {
            die('No Product found');
        }
        $option = explode(",",$request->option);
        $product->brand = $request->brand;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->img = $request->img;
        $product->department = json_encode($request->department);
        $product->options = json_encode($option);
        $product->original_price = $request->original_price;
        $product->discount_price = $request->discount_price;
        $product->discount_percentage = $request->discount_percentage;
        $product->stock = $request->stock;
        $product->featured = $request->featured;
        $product->author = session('user_data')['id'];
        
        $product->save();
        return redirect('product-list');
    }
    function bulkUploadsProducts(request $request)
    {
        return view('product.bulkAddProducts');
    }
    function postBulkProduct(request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->store('temp');
        $filePath = storage_path('app/' . $path);

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $imagePaths = $this->extractImages($sheet);
        $auction_id = $request->auction_id;
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex === 1) {
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $columns = [];
            foreach ($cellIterator as $cell) {
                $columns[] = $cell->getValue();
            }
            $img = isset($imagePaths[$rowIndex - 1]) ? $imagePaths[$rowIndex - 1] : 'null';
            echo $img;
            echo "<br>";
            Product::create([
                'brand' => trim($columns[0]),
                'title' => trim($columns[1]),
                'description' => trim($columns[2]),
                'options' => trim($columns[3]),
                'original_price' => trim($columns[4]),
                'discount_price' => trim($columns[5]),
                'discount_percentage' => trim($columns[6]),
                'stock' => trim($columns[7]),
                'img' => $img,
                'condition' => trim($columns[9]),
                'department' => trim($columns[10]),
                'author' => session('user_data')['id']
            ]);
        }
        Storage::delete($path);
        return redirect('product-list');
    }

    private function extractImages($sheet)
    {
        $imagePaths = [];
        foreach ($sheet->getDrawingCollection() as $drawing) {
            $coordinates = $drawing->getCoordinates();
            $rowIndex = $sheet->getCell($coordinates)->getRow();
            $originalFilename = "";
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                $extension = $this->mimeToExtension($drawing->getMimeType());
            } else {
                $path = $drawing->getPath();
                $imageContents = file_get_contents($path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $originalFilename = pathinfo($path, PATHINFO_BASENAME);
            }

            $newImageName = uniqid() . '.' . $extension;
            $postFields = [
                'path' =>'storage/product',
                'image' =>  curl_file_create($path, mime_content_type($path), basename($path)),
            ]  ;
            $path = $this->postApi('image-upload',$postFields);  
            $imagePaths[$rowIndex - 1] = $path['storage_path'];;




            $path = $drawing->getPath();
            $imageContents = file_get_contents($path);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
        }

        return $imagePaths;
    }

    private function mimeToExtension($mime)
    {
        $mime_map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tif',
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : 'bin';
    }


    function productList(request $request)
    {
        $data['products'] = Product::all()->toArray();
        return view('product.productList', $data);
    }
}
