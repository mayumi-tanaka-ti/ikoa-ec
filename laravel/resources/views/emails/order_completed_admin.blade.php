<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規注文がありました</title>
</head>
<body>
    <p>管理者様</p>
    <p>新しい注文が入りました。</p>
    <p>注文者：{{ $userName }}</p>
    <p>ご注文内容：</p>
    <ul>
        @foreach($orderItems as $item)
            <li>{{ $item['name'] }} × {{ $item['quantity'] }}</li>
        @endforeach
    </ul>
    <p>合計金額：{{ $total }}円</p>
</body>
</html>
