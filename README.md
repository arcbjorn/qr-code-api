# QR Code Generator API

Generate customizable QR codes with analytics tracking and dynamic content.

## Features

- Generate QR codes (URLs, text, vCards, WiFi, etc.)
- Customization (colors, logo, size, error correction)
- Dynamic QR codes (editable after creation)
- Scan analytics and tracking
- Batch generation
- API endpoints
- Short URL integration

## API Usage

```bash
# Generate QR code
POST /api/qr/generate
{
  "data": "https://example.com",
  "size": 300,
  "format": "png",
  "color": "#000000",
  "background": "#ffffff",
  "logo": "path/to/logo.png"
}

# Dynamic QR code
POST /api/qr/dynamic
{
  "name": "Product Label",
  "data": "https://example.com/product/123"
}

# Update dynamic QR
PUT /api/qr/dynamic/{id}
{
  "data": "https://example.com/product/456"
}

# Analytics
GET /api/qr/{id}/analytics
```

## PHP Usage

```php
QRCode::create('https://example.com')
    ->size(500)
    ->color('#1a73e8')
    ->logo('logo.png')
    ->save('qr.png');
```

## QR Types

- URL, Plain text, Email, Phone, SMS
- vCard (contact), WiFi credentials
- Geo location, Calendar event

## Requirements

- PHP 7.2+
- Laravel 6.0
- GD or Imagick extension
