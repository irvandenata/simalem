<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <div style="
    text-align: center;
    ">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate(route('report-problem',$item->unique_code))) !!}">
    <br>
    <div style="font-size:24px;margin-top:5px">{{ $item->item->name }}</div>
    <div  style="font-size:18px;">{{ $item->serial_number }}</div>
  </div>
</body>

</html>
