<?php
/**
 * Scavix Web Development Framework
 *
 * Copyright (c) since 2012 Scavix Software Ltd. & Co. KG
 *
 * This library is free software; you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General
 * Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any
 * later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library. If not, see <http://www.gnu.org/licenses/>
 *
 * @author Scavix Software Ltd. & Co. KG http://www.scavix.com <info@scavix.com>
 * @copyright since 2012 Scavix Software Ltd. & Co. KG
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 */

/**
 * Initializes the textdata module
 * 
 * This module provides functions for text-file processing
 * @return void
 */
function textdata_init()
{
}

/**
 * Parses CSV data into an array.
 * 
 * See http://www.php.net/manual/de/function.str-getcsv.php#95132
 * @param string $csv CSV data as string
 * @param string $delimiter CSV delimiter used
 * @param string $enclosure CSV enclosure string
 * @param string $escape CSV escape string
 * @param string $terminator CSV line terminator
 * @return array An array with one entry per line, each beeing an array of fields
 */
function csv_to_array($csv, $delimiter = ',', $enclosure = '"', $escape = '\\', $terminator = "\n")
{
    $result = array();
    $rows = explode($terminator,trim($csv));
    $names = str_getcsv(array_shift($rows),$delimiter,$enclosure,$escape);
    $nc = count($names);
    foreach( $rows as $row )
	{
        if( trim($row) )
		{
            $values = str_getcsv($row,$delimiter,$enclosure,$escape);
            if( !$values )
				$values = array_fill(0,$nc,null);
            $result[] = array_combine($names,$values);
        }
	}
	return $result;
}

/**
 * Extracts the header from a CSV data string
 * 
 * This is usually the first line which contains the field names.
 * @param string $csv CSV data as string
 * @param string $delimiter CSV delimiter used
 * @param string $enclosure CSV enclosure string
 * @param string $escape CSV escape string
 * @param string $terminator CSV line terminator
 * @return array An array with one entry per field
 */
function csv_header($csv, $delimiter = ',', $enclosure = '"', $escape = '\\', $terminator = "\n")
{
	$rows = explode($terminator,trim($csv));
    return str_getcsv(array_shift($rows),$delimiter,$enclosure,$escape);
}

/**
 * Tries to detect the CSV field delimiter
 * 
 * This may be one of: ';'  ','  '|'  '\t'
 * @param string $csv CSV data as string
 * @param string $terminator CSV line terminator
 * @return string The delimiter that seems to match best
 */
function csv_detect_delimiter($csv,$terminator = "\n")
{
	$rows = explode($terminator,trim($csv));
	$r = $rows[0];
	$counts = array();
	foreach( array(';',',','|',"\t") as $delim )
		$counts[count(explode($delim,$r))] = $delim;
	krsort($counts);
    return array_shift($counts);	
}
