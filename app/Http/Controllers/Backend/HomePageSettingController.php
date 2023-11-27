<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomePageSetting;
use Illuminate\Http\Request;

class HomePageSettingController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $popularCategorySection = HomePageSetting::where('key', 'popular_category_section')->first();
        $sliderSectionOne = HomePageSetting::where('key', 'product_slider_section_one')->first();
        $sliderSectionTwo = HomePageSetting::where('key', 'product_slider_section_two')->first();
        $sliderSectionThree = HomePageSetting::where('key', 'product_slider_section_three')->first();

        return view('admin.home-page-setting.index', compact('categories', 'popularCategorySection', 'sliderSectionOne', 'sliderSectionTwo', 'sliderSectionThree'));
    }

  
    public function updatePopularCategorySection(Request $request)
    {
        $request->validate([
            'addmore.*.cat_one' => ['required'],
            // Add validation rules for other input fields here
        ], [
            'addmore.*.cat_one.required' => 'Category one field is required',
            // Add custom error messages for other fields
        ]);
    
        $data = [];
    
        foreach ($request->addmore as $index => $value) {
            $data[] = [
                'category' => $value['cat_one'],
                'sub_category' => $value['sub_cat_one'],
                'child_category' => $value['child_cat_one'],
                // Add other fields to the array                
               
            ];
        }
    
        HomePageSetting::updateOrCreate(
            ['key' => 'popular_category_section'],
            ['value' => json_encode($data)]
        );
    
        toastr('Updated successfully!', 'success', 'success');
    
        return redirect()->back();
    }


    public function updateProductSliderSectionOn(Request $request)
    {
        $request->validate([
            'cat_one' => ['required']
        ], [
            'cat_one.required' => 'Category filed is required'
        ]);

        $data = [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one,
            ];

        HomePageSetting::updateOrCreate(
            [
                'key' => 'product_slider_section_one'
            ],
            [
                'value' => json_encode($data)
            ]
        );

        toastr('Updated successfully!', 'success', 'success');

        return redirect()->back();

    }

    public function updateProductSliderSectionTwo(Request $request)
    {
        $request->validate([
            'cat_one' => ['required']
        ], [
            'cat_one.required' => 'Category filed is required'
        ]);

        $data = [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one,
            ];

        HomePageSetting::updateOrCreate(
            [
                'key' => 'product_slider_section_two'
            ],
            [
                'value' => json_encode($data)
            ]
        );

        toastr('Updated successfully!', 'success', 'success');

        return redirect()->back();
    }

    public function updateProductSliderSectionThree(Request $request)
    {
        $request->validate([
            'cat_one' => ['required'],
            'cat_two' => ['required']
        ], [
            'cat_one.required' => 'Part 1 Category filed is required',
            'cat_two.required' => 'Part 2 Category filed is required'

        ]);

        $data = [
            [
                'category' => $request->cat_one,
                'sub_category' => $request->sub_cat_one,
                'child_category' => $request->child_cat_one,
            ],
            [
                'category' => $request->cat_two,
                'sub_category' => $request->sub_cat_two,
                'child_category' => $request->child_cat_two,
            ]
        ];

        HomePageSetting::updateOrCreate(
            [
                'key' => 'product_slider_section_three'
            ],
            [
                'value' => json_encode($data)
            ]
        );

        toastr('Updated successfully!', 'success', 'success');

        return redirect()->back();
    }

}
