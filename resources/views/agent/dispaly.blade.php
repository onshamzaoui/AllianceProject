<html>
<head>
<title>Disable Context Menu</title>
<script type="text/jscript">
  function disableContextMenu()
  {
    window.frames["fraDisabled"].document.oncontextmenu = function(){alert("No way!"); return false;};   
    // Or use this
    // document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;    
  }  
</script>
</head>
<body bgcolor="#FFFFFF" onload="disableContextMenu();" oncontextmenu="return false">
<iframe id="fraDisabled" width="528" height="473" src="../uploads/guide pfe2021-2022.pdf#toolbar=0"></iframe>
<div style="width:510px;height:473px;background-color:transparent;position:absolute;top:0px;">
</body>
</html>