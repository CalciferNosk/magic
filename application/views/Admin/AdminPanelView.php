<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table>
    <thead>
        <tbody>
            <th>Year</th>
            <th>filename</th>
            <th>Action</th>
        </tbody>
    </thead>
</table>

   <?php  
//    var_dump($files);die;
    foreach($files as $key => $f):
        if($key == 0) continue;
        if($key == 1) continue;
    ?>
    <tr>
        <td><?= substr($f,4); ?></td>
        <td><?= $f ?></td>
        <td></td>
    </tr>
    <?php endforeach; ?>
</body>
</html>