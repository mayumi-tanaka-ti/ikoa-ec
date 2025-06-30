<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ご注文ありがとうございます</title>
</head>
<body>
    <p>{{ $userName }} 様</p>
    <p>この度はご注文いただき、誠にありがとうございます。</p>
    <p>ご注文内容：</p>
    <ul>
        @foreach($orderItems as $item)
            <li>{{ $item['name'] }} × {{ $item['quantity'] }}</li>
        @endforeach
    </ul>
    <p>合計金額：{{ $total }}円</p>
    <p>今後ともよろしくお願いいたします。</p>
</body>
</html>
