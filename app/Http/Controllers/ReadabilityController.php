<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use andreskrey\Readability\Readability;
use andreskrey\Readability\Configuration;
use andreskrey\Readability\ParseException;
use App\CustomClass\ReadabilityAlgorithm;

class ReadabilityController extends Controller
{
    public function read(Request $request)
    {
        // Log::info("Get inside read method");
        // Log::info($request);
        if($request->inputUrl){
                if (filter_var($request->inputUrl, FILTER_VALIDATE_URL) == true) {
                    $readability = new Readability(new Configuration());
                $html = file_get_contents($request->inputUrl);
                    try {
                        $readability->parse($html);
                        $readObj = new ReadabilityAlgorithm();
                        $titleOfThePage = $readability->getTitle();
                        $excerpt = $readability->getExcerpt();
                        $totalReadabiltyScore = $readObj->calculateReadabilityScore($readability->getContent());
                        $wordsCount = str_word_count($readability->getContent());
                        $readabiltyScore = (int)$totalReadabiltyScore;
                        if($readabiltyScore > 100){
                            $readabiltyScore = 95;
                            return view('welcome',compact('titleOfThePage','excerpt','readabiltyScore','wordsCount'));
                        }else{
                            return view('welcome',compact('titleOfThePage','excerpt','readabiltyScore','wordsCount'));
                        }
                    } catch (ParseException $e) {
                        return redirect()->back()->with('danger', 'Sorry! unable to process the url try again');
                    }
                }else{
                    return redirect()->back()->with('danger', 'Incorrect Url');
                }
            }else{
                return redirect()->back()->with('danger', 'No Url Found');
            }
    }
        
}