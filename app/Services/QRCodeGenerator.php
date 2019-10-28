<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeGenerator
{
    public static function create($data)
    {
        return new self($data);
    }

    protected $qrCode;
    protected $writer;

    public function __construct($data)
    {
        $this->qrCode = new QrCode($data);
        $this->writer = new PngWriter();
    }

    public function size($size)
    {
        $this->qrCode->setSize($size);
        return $this;
    }

    public function color($hexColor)
    {
        $rgb = $this->hexToRgb($hexColor);
        $this->qrCode->setForegroundColor($rgb);
        return $this;
    }

    public function background($hexColor)
    {
        $rgb = $this->hexToRgb($hexColor);
        $this->qrCode->setBackgroundColor($rgb);
        return $this;
    }

    public function logo($logoPath)
    {
        if (file_exists($logoPath)) {
            $this->qrCode->setLogoPath($logoPath);
        }
        return $this;
    }

    protected function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    public function save($path)
    {
        $result = $this->writer->write($this->qrCode);
        $result->saveToFile($path);
        return $path;
    }

    public function toDataUri()
    {
        $result = $this->writer->write($this->qrCode);
        return $result->getDataUri();
    }

    public static function vCard(array $data)
    {
        $vcard = "BEGIN:VCARD\nVERSION:3.0\n";
        $vcard .= "FN:{$data['name']}\n";

        if (isset($data['email'])) {
            $vcard .= "EMAIL:{$data['email']}\n";
        }

        if (isset($data['phone'])) {
            $vcard .= "TEL:{$data['phone']}\n";
        }

        if (isset($data['org'])) {
            $vcard .= "ORG:{$data['org']}\n";
        }

        $vcard .= "END:VCARD";

        return self::create($vcard);
    }

    public static function wifi($ssid, $password, $encryption = 'WPA')
    {
        $wifiString = "WIFI:T:{$encryption};S:{$ssid};P:{$password};;";
        return self::create($wifiString);
    }

    public static function email($email, $subject = '', $body = '')
    {
        $mailto = "mailto:{$email}";

        if ($subject || $body) {
            $mailto .= "?subject=" . urlencode($subject);
            if ($body) {
                $mailto .= "&body=" . urlencode($body);
            }
        }

        return self::create($mailto);
    }

    public static function geo($latitude, $longitude)
    {
        $geo = "geo:{$latitude},{$longitude}";
        return self::create($geo);
    }
}
