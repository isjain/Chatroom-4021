<?php

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript">
        //<![CDATA[
        function load() {
            var name = "<?php print $name; ?>";


            //delete this line 
            //window.parent.frames["message"].document.getElementById("username").setAttribute("value", name)

            setTimeout("document.getElementById('msg').focus()",100);
        }



                // select color
        function select(color) {
            var fld = document.getElementById("color");
            if (color != fld.value) {
                if (!confirm("Do you want to use the new color?!"))
                    return;
                fld.value=color;
            }
        }
        
       function setCookie(name, value, expires, path, domain, secure) {
            var curCookie = name + "=" + escape(value) +
                ((expires) ? "; expires=" + expires.toGMTString() : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
            document.cookie = curCookie;
        }

        
        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()">
        <form action="add_message.php" method="post">
            <table border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td>What is your message?</td>
                </tr>
                <tr>
                    <td><input class="text" type="text" name="message" id="msg" style= "width: 780px" /></td>
                </tr>
                <tr>
                    <td>
                        <input class="button" type="submit" value="Send Your Message" style="width: 200px" />
                        <input id="color" type="hidden" name="color" value="<?php echo isset($_COOKIE['color']) ? $_COOKIE['color'] : '#000' ?>"/>
                        <span>
                            <span>
                                Choose your color:
                            </span>
                            <span>
                                <button class="color-button" style="background: #000" onclick="select('#000');return false;"></button>
                                <button class="color-button" style="background: #1ff" onclick="select('#1ff');return false;"></button>
                                <button class="color-button" style="background: #f00" onclick="select('#f00');return false;"></button>
                                <button class="color-button" style="background: #00f" onclick="select('#00f');return false;"></button>
                                <button class="color-button" style="background: #0f0" onclick="select('#0f0');return false;"></button>
                                <button class="color-button" style="background: #50f" onclick="select('#50f');return false;"></button>
                            </span>
                        </span>
                    </td>
                </tr>
            </table>
        </form>
        <hr />

        <!--logout button-->

        <form action="logout.php" method="post" onsubmit="alert('You have successfully logged out!')">
            <table border="0" cellspacing="5" cellpadding="0">
                <tr style="border-top: 1px solid gray">
                    <td><input class="button" type="submit" value="Logout" style="width: 200px" /></td>
                </tr>
            </table>
        </form>

<a href="onlineuser.html" target="_blank">
    <button style="width:200px; height:25px"> Show Online Users</button>
</a>

    </body>
</html>
