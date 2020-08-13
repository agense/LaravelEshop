<?php
use App\Models\Setting;
use Illuminate\Support\Str;
use Carbon\Carbon;

// CONVERT MONETARY VALUES
/**
 * Return formatted monetary amounts for display with currency
 * @param integer $amount
 * @return string formatted monetary value
 */
function formatMoney($amount){
  return Setting::displayCurrency().' '.number_format($amount, 2);
}
/**
 * Converts sums saved in DB as integer in cents to money value
 */
function convertIntToMoney($int){
  return round($int/100, 2);
}
/**
 * Converts sums saved in DB as integer in cents to money value and returns formatted monetary amounts with currency
 */
function monetaryDisplay($int){
  return formatMoney(convertIntToMoney($int));
}

/**
 * Returns any float type monetary value to integer (to cents by multiplying by 100)
 */
function formatMoneyToInt($int){
  return intval($int * 100);
}


// FORMAT STRINGS
/**
 * Converts text separated by with underscores to plain text format
 */
function formatToText(String $value, $changeCase = true){
  $text = str_replace('_', ' ', $value);
  if($changeCase){
    return ucwords($text);
  }
  return $text;
}

/**
 * Removes dashes and underscores from string
 */
function formatAsText(String $value, $changeCase = true){
  $text = str_replace('-', ' ', str_replace('_', ' ', $value));
  if($changeCase){
    return ucwords($text);
  }
  return $text;
}

/**
 * Converts slug type text with dashes to plain text format with first letters capitalized
 */
function slugToText(String $value){
  return ucwords( str_replace('-', ' ', $value));
}

/**
 * Converts plain text to slug  in lowercase
 */
function textToSlug(String $value){
  return strtolower( str_replace(' ', '-', $value));
}

/**
 * Converts plain text to text separated by with underscores in lowercase
 */
function formatTextToValue(String $value, $changeCase = true){
  if($changeCase == false){
    return str_replace(' ', '_', $value);
  }
  return str_replace(' ', '_', strtolower($value));
}

  /**
   * Reformats strings with ':' character for display
   * If $asString is true, ':' are replaced by commas
   * Otherwise, and array is created for each item separated by ':'
   */
  function formatArraylikeString($val, $asString = false){
    
    if(!str_contains($val, ':')){
      return $val;
    }else{
      $values = explode(':',$val);
      
      $formatted = collect($values)->map(function ($v, $key) {
        return $v;
      })->toArray();
      if($asString){
        return implode(', ', $formatted);
      }
      return $formatted;
    }
  }


// FORMAT DATES
/**
 * Removes time from the date
 */
function formatDateToDay($date){
  return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
}

/**
 * Adds time to the date
 * If $end argument is true, sets time to the end of day, otherwise to the beginning of day
 */
function formatDateToFull(String $date, $end = false){
  if (Carbon::createFromFormat('Y-m-d', $date) !== false) {
    if($end){
      $date.=' 23:59:59';
    }else{
      $date.= ' 00:00:00';
    }
  }
  return $date;
}


// ARRAYS AND OPTION LISTS
/**
 * Converts arrays of model properties to arrays where keys and values are based on text value of the property
 */
function propertyList(Array $properties){
    $options = [];
    foreach($properties as $key => $value){
        $options[formatToText($value)] = $value;
    }
    return $options;
}

/*
 Returns an array of options with name->value pairs 
 */
function optionList(Array $properties){
  $options = [];
  foreach($properties as $key => $value){
      //if key is numeric, create key from value
      $key = is_numeric($key) ? ($value) : $key;
      $options[formatToText($key, true)] = $value;
  }
  return $options;
}

/**
 * Gets a key for a specific value of the array
 */
function getPropertyKey(String $value, Array $properties){
  return array_search(Str::snake($value), $properties);
}


// DISPLAY HELPERS
/**
 * Return active category for the menu display
 */
function setActiveCategory($category, $output = "active"){
  return request()->category == $category ? $output : '';
}

/**
 * Check if a number is even or odd
 */
function checkEven($number){
  if($number  % 2 == 0) return true;
  return false;
}

// ORDER HELPERS
/**
 * Checks if ordering is ascending or descending
 */
function sortOrder($order){
  if(!$order){
    return 'ASC';
  }
  return strtoupper($order) == 'DESC' ? 'DESC' : 'ASC';
}

// FILTER HELPERS
/**
 * Checks if current filter is the active filter or one of the active filters
 */
function isActiveFilter($key, $val, $filters){
  if(array_key_exists($key, $filters)){
    if(is_array($filters[$key]) && in_array($val, $filters[$key])){
      return true;
    }elseif(is_string($filters[$key]) && $val == $filters[$key]){
      return true;
    }else{
      return false;
    }
  }
  return false;
}



