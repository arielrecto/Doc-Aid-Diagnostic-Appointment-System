<?php

namespace App\Http\Controllers;

use App\Models\ImageCarousel;
use Illuminate\Http\Request;

class ImageCarouselController extends Controller
{
    public function __construct(public ImageCarousel $imageCarousel)
    {

    }


    public function index(){
        $images = $this->imageCarousel->get();


        return view('users.admin.carousel.index', compact(['images']));
    }
    public function create(){

        return view('users.admin.carousel.create');
    }
    public function store(Request $request){

        $request->validate([
            'image' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $imageName = 'carouselIMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/carousel', $imageName, 'public');

        $this->imageCarousel->create([
            'image' => asset('/storage/' . $dir),
            'title' => $request->title,
            'description' => $request->description
        ]);

        return to_route('admin.imageCarousel.index')->with(['message' => 'Image Uploaded']);
    }
    public function show(string $id, Request $request){

        $carousel = ImageCarousel::find($id);

        $is_active = $request->query('is_active');

        if($is_active != null){
            $carousel->update(['active' => $is_active  == 'true' ? true : false]);
        }


        return view('users.admin.carousel.show', compact(['carousel']));
    }
    public function edit(string $id){


    }
    public function update(Request $request, string $id){


    }
    public function destroy(string $id){


    }
}
