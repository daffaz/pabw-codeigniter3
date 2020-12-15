<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <!-- <style type="text/css" media="screen">
        body {
            background-color: #EEE;
            font-family: Arial;
        }

        .container {
            width: 80%;
            padding: 20px;
            background-color: #fff;
            min-height: 300px;
            margin: 40px auto;
            border-radius: 10px;
        }

        table {
            border: solid thin #000;
            border-collapse: collapse;
            width: 100%;
        }

        tr {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 6px 12px;
            border-bottom: solid thin #EEE;
            text-align: left;
        }
    </style> -->
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter';
        }

        .container {
            margin: 30px auto;
            width: 80%;
            min-height: 100vh;
            background-color: #fff;
            box-shadow: 0px 11px 15px -7px rgba(0, 0, 0, 0.2), 0px 24px 38px 3px rgba(0, 0, 0, 0.14), 0px 9px 46px 8px rgba(0, 0, 0, 0.12);
            border-radius: 10px;
            padding: 20px;
        }

        table,
        th,
        td {
            margin: 10px auto;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        td,
        th {
            padding: 5px 15px;
        }

        tr:nth-child(odd) {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="text-align:center"><?= $title ?></h1>
        <a href="<?= base_url('index.php/provinsi/export') ?>">Unduh spreadsheet</a>
        <hr>
        <?php echo form_open_multipart('Provinsi/upload') ?>
        <input type="file" name="userupload" size="20">
        <input type="submit" value="Upload">
        </form>
        <table>
            <tr>
                <th width="5%" style="text-align: left;">Kode</th>
                <th style="text-align: left;">Provinsi</th>
            </tr>
            <?php foreach ($provinsi as $p) : ?>
                <tr>
                    <td><?= $p->id_provinsi ?></td>
                    <td><?= $p->nama_provinsi ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>

</html>