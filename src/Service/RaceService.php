<?php

namespace App\Service;

class RaceService
{
     public function uploadFile(): bool
     {
          $uploadDir = $_SERVER['DOCUMENT_ROOT']."/Downloads";
          $uploadFile = $uploadDir.basename($_FILES['csv_file']['name']);

          return move_uploaded_file($_FILES['csv_file']['tmp_name'], $uploadFile);
     }
}