<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
    <title>Список аудиофайлов</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
    <ul>
        @foreach($items as $item)
        <li>
            @if(isset($item->name))Title: {{ $item->name }}@endif | @if(isset($item->duration))Duration: {{ $item->duration }}@endif
            <a href="{{ route('play', ['id' => $item->id]) }}">play</a>
        </li>
        @endforeach
    </ul>
</body>
</html>
