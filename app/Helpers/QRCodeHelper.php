<?php

namespace App\Helpers;

use App\Model\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class QRCodeHelper
{
    /*
     * Generate qr code.
     *
     * @param string $json
     * @param string $fileNameWithPath
     *
     * @return array
     */
    public static function generateQrCode($json, $fileNameWithPath)
    {
        // Example Encypt and Decrypt
        //$encrypted = Crypt::encryptString('7778989722');
        
        //echo $decrypted = Crypt::decryptString($encrypted);
        //exit;
        
        // Example QR CODE
        
        //$isSuccess = QRCodeHelper::generateQrCode('{"table_id":77789897221}', public_path('images/qr1.png'));
        //dd($isSuccess);
        
        $json = urlencode($json);
        
        $url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={$json}&choe=UTF-8";
        
        try {
            
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url);
            

            if(file_exists($fileNameWithPath))
            {
                if(is_file($fileNameWithPath))
                {
                    unlink($fileNameWithPath);
                }
            }

            $fp = fopen($fileNameWithPath, 'x');
            fwrite($fp, $response->getBody());
            fclose($fp);
            
           // dd($fileNameWithPath);
             //Set the Content Type
             header('Content-type: image/jpeg');
           
             // Create Image From Existing File
             $jpg_image = imagecreatefromjpeg($fileNameWithPath);
             
             // Allocate A Color For The Text
             $white = imagecolorallocate($jpg_image, 255, 255, 255);
 
             // Set Path to Font File
             $font_path = 'font.TTF';
 
             // Set Text to Be Printed On Image
             $text = "This is a sunset!";
 
             // Print Text On Image
             imagettftext($jpg_image, 25, 0, 75, 300, $white, $font_path, $text);
             
             // Send Image to Browser
             imagejpeg($jpg_image);
            
             $fp = fopen($jpg_image, 'x');
            fwrite($fp, $response->getBody());
            fclose($fp);
             //
             // Clear Memory
             //imagedestroy($jpg_image);

            return [
                'status' => 1,
                'json' => $json,
            ]; 
        }
        catch (\Exception $e)
        {
           return [
               'status' => 0
           ];
           
        }
        
    }
}
