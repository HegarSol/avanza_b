<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('check_date')) {
  /**
   * VALID DATE
   * 
   * Checks if the string its a well formated date value
   * 
   * @param string $str_dt The string to be checked
   * @param string $str_dateformat The format of the date string
   * @param string $str_timezone The timezone used to validate the date
   * 
   * @return boolean If the string its a valid date or datetime 
   */
  function check_date($str_dt, $str_dateformat, $str_timezone = 'America/Mexico_City') {
    $date = DateTime::createFromFormat(
      $str_dateformat,
      $str_dt,
      new DateTimeZone($str_timezone)
    );
    return $date && DateTime::getLastErrors()['warning_count'] == 0;
  }
}