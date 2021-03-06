<?php

namespace Pherserk\Tombola\Service;

use Pherserk\Tombola\Bucket;
use Pherserk\Tombola\Exception\FolderException;
use Pherserk\Tombola\Exception\RowException;
use Pherserk\Tombola\Folder;
use Pherserk\Tombola\Row;

class FolderSet
{
	public static function generate()
	{
		$bucket = new Bucket();
		$errors = 0;

		$rows = [];
		for ($k=0; $k<18; $k++) {
			$row = new Row();
			for ($i=0;$i<5;$i++) {
				try {
					$number = $bucket->extractNumber();
					$row->addNumber($number);
				} catch(RowException $e) {
					$errors++;
				}					
			}
			$rows[] = $row;
		}	

		$folders = [];
		for($i=0; $i<6; $i++) {
			$folder = new Folder();
			try {
				$folder->addRow(array_pop($rows));
				$folder->addRow(array_pop($rows));
				$folder->addRow(array_pop($rows));
			} catch(FolderException $e) {
				$errors++;
			}	

			$folders[] = $folder;
		}		

		return $folders;	
	}
}