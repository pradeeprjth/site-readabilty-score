<?php
namespace App\CustomClass;


use App\CustomClass\ReadabilitySyllableCheckPattern;

class ReadabilityAlgorithm {
   function countSyllable($strWord) {
      $pattern = new ReadabilitySyllableCheckPattern();
      $strWord = trim($strWord);

      // Check for problem words
      if (isset($pattern->{'probWords'}[$strWord])) {
         return $pattern->{'probWords'}[$strWord];
      }

      // Check prefix, suffix
      $strWord = str_replace($pattern->{'prefixSuffixPatterns'}, '', $strWord, $tmpPrefixSuffixCount);

      // Removed non word characters from word
      $arrWordParts = preg_split('`[^aeiouy]+`', $strWord);
      $wordPartCount = 0;
      foreach ($arrWordParts as $strWordPart) {
         if ($strWordPart <> '') {
               $wordPartCount++;
         }
      }
      $intSyllableCount = $wordPartCount + $tmpPrefixSuffixCount;

      // Check syllable patterns 
      foreach ($pattern->{'subSyllablePatterns'} as $strSyllable) {
         $intSyllableCount -= preg_match('`' . $strSyllable . '`', $strWord);
      }

      foreach ($pattern->{'addSyllablePatterns'} as $strSyllable) {
         $intSyllableCount += preg_match('`' . $strSyllable . '`', $strWord);
      }

      $intSyllableCount = ($intSyllableCount == 0) ? 1 : $intSyllableCount;
      return $intSyllableCount;
   }

   function calculateReadabilityScore($stringText) {
      # Calculate score
      $totalSentences = 1;
      $punctuationMarks = array('.', '!', ':', ';');

      foreach ($punctuationMarks as $punctuationMark) {
         $totalSentences += substr_count($stringText, $punctuationMark);
      }

      // get ASL value
      $totalWords = str_word_count($stringText);
      $ASL = $totalWords / $totalSentences;

      // find syllables value
      $syllableCount = 0;
      $arrWords = explode(' ', $stringText);
      $intWordCount = count($arrWords);
      //$intWordCount = $totalWords;

      for ($i = 0; $i < $intWordCount; $i++) {
         $syllableCount += $this->countSyllable($arrWords[$i]);
      }

      // get ASW value
      $ASW = $syllableCount / $totalWords;

      // Count the readability score
      $score = 206.835 - (1.015 * $ASL) - (84.6 * $ASW);
      return $score;
   } 
} 

