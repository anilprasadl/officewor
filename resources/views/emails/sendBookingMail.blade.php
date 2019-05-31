<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
* { 
    margin:0;
    padding:0;
}
* { font-family: "Raleway", "Helvetica", Helvetica, Arial, sans-serif; }
img { 
    max-width: 100%; 
}
body {
    -webkit-font-smoothing:antialiased; 
    -webkit-text-size-adjust:none; 
    width: 100%!important; 
    height: 100%;   
}
table.head-wrap { width: 100%;}
.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}
table.body-wrap { width: 100%;}
table.footer-wrap { width: 100%;    clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
    font-size:10px;
    font-weight: bold;  
}
p{ 
    margin-bottom: 10px; 
    font-weight: normal; 
    font-size:14px; 
    line-height:1.6;
}
.container {
    display:block!important;
    max-width:600px!important;
    margin:0 auto!important; 
    clear:both!important;
}
.content {
    padding:15px;
    max-width:600px;
    margin:0 auto;
    display:block; 
}
.content table { width: 100%; }
@media only screen and (max-width: 600px) {
    
    a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}
    div[class="column"] { width: auto!important; float:none!important;}
    
    table.social div[class="column"] {
        width:auto!important;
    }
}
</style>
</head>
<body bgcolor="#FFFFFF">
<table class="head-wrap" bgcolor="#2196f3">
    <tr>
        <td class="header container">
                <div class="content">
                    <table bgcolor="#2196f3">
                    <tr>
                    Your Slot is Booked !!
                        <td align="right"><h6 class="collapse"></h6></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<table class="body-wrap">
    <tr>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <h3 style="padding:7px 0px 7px 0px;">Hi {{$name}},</h3>
                            <p style="padding:15px 0px 15px 0px;">Thank you for registering to <strong>DevOps Tool</strong> for {{$event_name}}.</p>
                            <!-- <br/> -->
                            <p>The Slot Starts at <strong>{{ $event_start_date }}</strong></p>
                            <br/>
                            <p>If you have any questions please contact DevOps Team.</p>
                            <br/>
                            <p>Thank You.</p>
                            <br/>
                            <p>-DevOps Tool</p>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td class="container" style="background:rgba(33,150,243,1);">
                            <div class="content">
                                <table>
                                    <tr>
                                        <td align="center">
                                             DevOps Tool
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<table class="footer-wrap">
    <tr>
        <td class="container">
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <!-- <img src="{{ asset('asset/img/upreachpng.jpg')}}" width="130px"/> -->
                            <p style="font-size:10px !important; color:grey;">With Regards-<strong>BOOK MY HUB</br>JMAN GROUP-CHENNAI</br></p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>
</html>