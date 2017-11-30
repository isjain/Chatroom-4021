<?php

// get the name from cookie
$name = "";
if (isset($_COOKIE["name"])) {
    $name = $_COOKIE["name"];
}

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script language="javascript" type="text/javascript">
        //<![CDATA[
        var loadTimer = null;
        var request;
        var datasize;
        var lastMsgID;

        function load() {
            var username = document.getElementById("username");
            if (username.value == "") {
                loadTimer = setTimeout("load()", 100);
                return;
            }

            loadTimer = null;
            datasize = 0;
            lastMsgID = 0;


            
            var node = document.getElementById("chatroom");
            node.style.setProperty("visibility", "visible", null);

            getUpdate();
        }

        function unload() {
            var username = document.getElementById("username");
            if (username.value != "") {
                //request = new ActiveXObject("Microsoft.XMLHTTP");
                request =new XMLHttpRequest();
                request.open("POST", "logout.php", true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(null);
                username.value = "";
            }
            if (loadTimer != null) {
                loadTimer = null;
                clearTimeout("load()", 100);
            }
        }

        function getUpdate() {
            //request = new ActiveXObject("Microsoft.XMLHTTP");
            request =new XMLHttpRequest();
            request.onreadystatechange = stateChange;
            request.open("POST", "server.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("datasize=" + datasize);
        }

        function stateChange() {
            if (request.readyState == 4 && request.status == 200 && request.responseText) {
                var xmlDoc;
                try {
                    xmlDoc =new XMLHttpRequest();
                    xmlDoc.loadXML(request.responseText);
                } catch (e) {
                    var parser = new DOMParser();
                    xmlDoc = parser.parseFromString(request.responseText, "text/xml");
                }
                datasize = request.responseText.length;
                updateChat(xmlDoc);
                getUpdate();
            }
        }


////////////////////////////////////////////////////////        bullshit for URL
        //         function updateChat(xmlDoc) {
        //     var messages = xmlDoc.getElementsByTagName("message");
        //     var msgStr = []
            
        //     for (var i = lastMsgID; i < messages.length; i++) {
        //         // Obtain user name and message content from each message node,
        //         // and add to the variable msg
        //         // We use "|" as a separator to separate each user name and message content
        //         var msg = messages.item(i);
        //         msgStr.push(new Message(msg.getAttribute("name"), msg.firstChild.nodeValue))
        //     }
        //     lastMsgID = messages.length;
        //     addMsgsToChatroom(msgStr);
        // }
        // function applyURL(content){
        //     var words = content.split(" ")
        //     var s = ""
        //     for (var i=0; i<words.length; i++){
        //         if (words[i].indexOf("http://")==0)
        //             words[i] = "<a href =\"" + words[i] + "\" target=\"_blank\">" + words[i] + "</a>"
        //         s = s + words[i] + " "
        //     }
        //     return s
        // }
        // function addMsgsToChatroom(msgStr){
        //     for (var i = 0; i < msgStr.length ; i++){
        //         var msg = document.createElement("p");
        //         msg.innerHTML = msgStr[i].name + " : " + applyURL(msgStr[i].content)
        //         //var node = document.createTextNode(msgStr[i].name + " : " +msgStr[i].content);
                
        //         //msg.appendChild(node);
        //         chatroom.appendChild(msg);
        //     }
        //     window.scrollTo(0,document.body.scrollHeight); 
        // }


        function updateChat(xmlDoc) {
            //point to the message nodes
            var messages = xmlDoc.getElementsByTagName("message");
            //console.log(messages);
            //Obtain user name and message content from each message node
            for(var i = lastMsgID; i < messages.length; i++) {
                var messageNode = messages.item(i);
                var message = messageNode.innerHTML;
                var username = messageNode.getAttribute('name');
                var color = messageNode.getAttribute('color');
                console.log(color);
                //Call function showMessage() to display message
                showMessage(username, message, color);
            }
            //Record current message node(messages.length) so that you can start to
            //process the messages from here next time
            lastMsgID = messages.length;
            
            // create a string for the messages
            /* Add your code here */
        }
        function showMessage(nameStr, contentStr, colorStr){
                var node = document.getElementById("chattext");
                // Create the name text span
                var nameNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
                // Set the attributes and create the text
                nameNode.setAttribute("x", 100);
                nameNode.setAttribute("dy", 20);
                nameNode.appendChild(document.createTextNode(nameStr));
                nameNode.setAttribute("fill", colorStr)
                // Add the name to the text node
                node.appendChild(nameNode);
                // Create the score text span
                var conetentNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
                // Set the attributes and create the text
                conetentNode.setAttribute("x", 220);
                conetentNode.setAttribute("fill", colorStr)

                conetentNode.appendChild(document.createTextNode(applyURL(contentStr)));
                
                // Add the name to the text node
                node.appendChild(conetentNode);
                // var link = document.createElementNS("http://www.w3.org/2000/svg", "a");
                // link.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', "youtube.com");
                // node.appendChild(link);
        }

        function applyURL(content){
                var words = content.split(" ")
                var s = ""
                for (var i=0; i<words.length; i++){
                    if (words[i].indexOf("http://")==0) {



            // Set the attributes and create the text
                            var conetentNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

            conetentNode.setAttribute("x", 600);

            var a_tag = document.createElementNS("http://www.w3.org/2000/svg", "a");
            a_tag.setAttribute("fill", "red")
            a_tag.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", words[i]);
            a_tag.setAttribute("target", "_blank");
            a_tag.setAttribute("style", "text-decoration:underline")
            a_tag.appendChild(document.createTextNode(words[i]));

            conetentNode.appendChild(a_tag);
            var node = document.getElementById("chattext");
            node.appendChild(conetentNode);


                    }
                    s = s + words[i] + " " 
                }
                return s
        }



       // var contentNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

       //  // Set the attributes and create the text
       //  contentNode.setAttribute("x", 200);
       //  contentNode.setAttribute("fill", color);

       //  var a_tag = document.createElementNS("http://www.w3.org/2000/svg", "a");
       //  a_tag.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", "http://google.com");
       //  a_tag.appendChild(document.createTextNode("google"));

       //  contentNode.appendChild(a_tag);


       //  // Add the name to the text node
       //  node.appendChild(contentNode);













// var svgElement = document.getElementById ("svgTag");

// var link = document.createElementNS("http://www.w3.org/2000/svg", "a");
// link.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', "page2.html");
// svgElement.appendChild(link);

// var box = document.createElementNS("http://www.w3.org/2000/svg", "rect");
// box.setAttribute("x", 30); 
// box.setAttribute("y", 30);
// box.setAttribute("width", 200);
// box.setAttribute("height", 50);
// box.setAttribute("fill", "blue");
// link.appendChild(box);


        </script>
    </head>

    <body style="text-align: left" onload="load()" onunload="unload()">
    <svg width="800px" height="2000px"
     xmlns="http://www.w3.org/2000/svg"
     xmlns:xhtml="http://www.w3.org/1999/xhtml"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     xmlns:a="http://www.adobe.com/svg10-extensions" a:timeline="independent"
     >

<!--         <g id="chatroom" style="visibility:hidden">                
 -->        
        <g id="chatroom">                

 <rect width="790" height="2000" style="fill:white;stroke:red;stroke-width:2"/>
        <text x="360" y="40" style="fill:red;font-size:30px;font-weight:bold;text-anchor:middle">Chat Window</text> 
        <text id="chattext" y="80" style="font-size: 14px;font-weight:bold"/>
      </g>
  </svg>
  
         <form action="">
            <input type="hidden" value="<?php print $name; ?>" id="username" />
        </form>

    </body>
</html>
