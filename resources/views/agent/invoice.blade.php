<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Document</title>
    <style>
        .container {
            width: 680px;
            padding: 10px;
        }
        *{
            font-family: 'Lato', sans-serif;
        }

    </style>
</head>

<body>


    <div class="container">
        <div class="invoice-container" ref="document" id="html">
            <table style="width:100%; height:auto;  text-align:center; " BORDER=0 CELLSPACING=0>
                <thead style="background:#fafafa; padding:8px;">
                    <tr style="font-size: 20px;">
                        <img src="https://i.ibb.co/7brjPnR/logo.png" alt=""></a>
                    </tr>
                </thead>
                <tbody style="background:#ffff;padding:20px;">
                    <tr>
                        <td colspan="4"
                            style="padding:20px 0px 0px 20px;text-align:left;font-size: 16px; font-weight: bold;color:#000;">
                            Hello, {{$instructor->first_name}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:left;padding:10px 10px 10px 20px;font-size:14px;">Your Program Invoice</td>
                    </tr>
                </tbody>
            </table>
            <table
                style="width:100%; height:auto; background-color:#fff;text-align:center; padding:10px; background:#fafafa">
                <tbody>
                    <tr style="color:#6c757d; font-size: 20px;">
                        <td
                            style="border-right:1.5px dashed  #DCDCDC; width:25%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">
                            Creation Date</td>
                        <td
                            style="border-right: 1.5px dashed  #DCDCDC ;width:25%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">
                            Program Ref.</td>
                        <td
                            style="border-right:1.5px dashed  #DCDCDC ;width:25%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">
                            Payment</td>
                        <td style="width:25%;font-size:12px;font-weight:700;padding: 0px 0px 10px 0px;">Address
                        </td>
                    </tr>
                    <tr style="background-color:#fff; font-size:12px; color:#262626;">
                        <td
                            style="border-right:1.5px dashed  #DCDCDC ;width:25%; font-weight:bold;background: #fafafa;">
                            {{$program->created_at}}</td>
                        <td
                            style="border-right:1.5px dashed  #DCDCDC ;width:25% ; font-weight:bold;background: #fafafa;">
                            0000{{$program->id}}</td>
                        <td
                            style="border-right:1.5px dashed  #DCDCDC ;width:25%; font-weight:bold;background: #fafafa;">
                            Online</td>
                        <td style="width:25%; font-weight:bold;background: #fafafa;">Tunis , Tunisia</td>
                    </tr>
                </tbody>
            </table>
            <table
                style="width:100%; height:auto; background-color:#fff; margin-top:0px;  padding:20px; font-size:12px; border: 1px solid #ebebeb; border-top:0px;">
                <thead>
                    <tr style=" color: #6c757d;font-weight: bold; padding: 5px;">
                        <td></td>
                        <td  style="text-align: left;">Program Details</td>
                        <td style="text-align: center;">PRICE</td>
                        <td style="padding: 10px;text-align:center;">DIFFCULTY</td>
                        <td style="text-align: right;padding: 10px;">SHARE PERCENTEGE</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:20%; ">
                        </td>
                        <td style="width:20%;margin-left:10px;text-align: center;">{{$program->title}}</td>
                        <td style="width:20%;padding: 10px; text-align:center;">{{$program->price}} DT</td>
                        <td style="width:20%;padding: 10px;text-align: center;">{{$program->difficulty}}</td>
                        <td style="width:30%; ;font-weight: bold;font-size: 14px;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="text-align:end;font-size:13px;">{{$program->percentege}} %</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                style="width:100%; height:auto; background-color:#fff;padding:20px; font-size:12px; border: 1px solid #ebebeb; border-top:0">
                <tbody>
                    <tr style="padding:20px;color:#000;font-size:15px">
                        <td style="font-weight: bold;padding:5px 0px">Total</td>
                        <td style="text-align:right;padding:5px 0px;font-weight: bold;font-size:16px;">{{$program->price}} DT</td>
                    </tr>

                    <tr>
                        <td colspan="2" style="font-weight:bold;"><span style="color:#c61932;font-weight: bold;">THANK
                                YOU</span> for shipping with us!</td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="font-weight:bold;text-align:left;padding:5px 0px 0px 00px;font-size:14px;">
                            Alliance<span>+</span></td>
                    </tr>
                </tbody>
                <tfoot style="padding-top:20px;font-weight: bold;">
                    <tr>
                        <td style="padding-top:20px;">Need help? Contact us <span style="color:#c61932">
                                alliance@gmail.com </span></td>
                    </tr>
                </tfoot>
            </table>



        </div>
    </div>

</body>

</html>
