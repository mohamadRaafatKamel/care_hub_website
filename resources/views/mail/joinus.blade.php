<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care-Hub</title>
</head>
<body>
<h1>Invoice Information</h1>

<p>Dear @if(isset($data['name'])) {{ $data['name'] }} @else User @endif,</p>
<p>Find invoices for your purchase order INV005, INV007, INV009.</p>

</body>
</html>
