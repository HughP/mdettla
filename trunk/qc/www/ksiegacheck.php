<?php
ob_start();



$poczatekstrony = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"> <html> <head>  <META HTTP-EQUIV=\"Content-type\" CONTENT=\"text/html; charset=iso-8859-2\">  <META NAME=\"Keywords\" CONTENT=\"Queen, zesp�, Corner, muzyka, rock, recenzje, dyskografia, artyku�y, teksty, piosenki, tabulatury, wywiady, biografia, ciekawostki, zdj�cia, historia, zespo�u, Freddie, Mercury, Brian, May, Roger, Taylor, John, Deacon, Action, Mag\">  <META NAME=\"Description\" CONTENT=\"Strona Queen Corner - magazynu o kultowym zespole Queen! Artyku�y, recenzje, teksty piosenek i t�umaczenia, tabulatury, zdj�cia, download, historia zespo�u, ciekawostki.\">  <META NAME=\"Language\" CONTENT=\"pl\"> <LINK REL=\"stylesheet\" href=\"lay/style.css\" TYPE=\"text/css\"> <title>Queen Corner online</title> </head>  <body link=#2222cc alink=#2222cc vlink=#2222cc bgcolor=#cacaca text=#050505 leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>   <table bgcolor=#000000 width=770 height=80 border=0 cellpadding=0 cellspacing=0 align=center>  <tr>   <td width=129 background=\"lay/logo1.jpg\">   </td>   <td width=641 background=\"lay/logo2.jpg\" style=\"background-repeat: no-repeat\">   </td>  </tr> </table>   <table bgcolor=#fafafa width=770 border=0 cellpadding=0 cellspacing=0 align=center>  <tr>   <td width=130 background=\"lay/menu1.gif\" style=\"background-repeat: repeat-y\" valign=top>   <table width=130 border=0 cellpadding=0 cellspacing=0>   <tr>    <td colspan=4 height=45 background=\"lay/logo3.jpg\" style=\"background-repeat: no-repeat\">    </td>   </tr>   <tr height=1>    <td rowspan=32 width=2></td>    <td width=7 bgcolor=#cacaca></td>    <td width=105 height=1 valign=middle bgcolor=#cacaca></td>    <td rowspan=32 width=16></td>   </tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=home\" class=menu>HOME</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=news\" class=menu>NEWSY</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=42><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=recenzje\" class=menu>RECENZJE</a><br>  <small>&nbsp; > </small><a href=\"index.php?go=recenzje\" class=menusm>albumy</a><br>  <small>&nbsp; > </small><a href=\"index.php?go=recenzjet\" class=menusm>teledyski</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=teksty\" class=menu>ARTYKU�Y</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=wywiady\" class=menu>WYWIADY</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=64><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=biografia\" class=menu>BIOGRAFIE</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=biografia\" class=menusm>Freddie Mercury</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=biografia2\" class=menusm>Brian May</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=biografia3\" class=menusm>Roger Taylor</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=biografia4\" class=menusm>John Deacon</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=42><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=historia\" class=menu>HISTORIA</a><br>   <small>&nbsp; </small><a href=\"index.php?go=historia\" class=menusm>1968-1976</a><small>, </small>   <a href=\"index.php?go=historia2\" class=menusm>1977-1982</a><br>   <small>&nbsp; </small><a href=\"index.php?go=historia3\" class=menusm>1977-1982</a><small>, </small>   <a href=\"index.php?go=historia4\" class=menusm>1983-1991</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=30><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=pio\" class=menu>PIOSENKI</a><br>   <small>&nbsp; &nbsp; </small><a href=\"index.php?go=pio\" class=menusm>zesp�</a><small> / </small>   <a href=\"index.php?go=piosolo\" class=menusm>solo</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=30><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=tabulatury\" class=menu>TABULATURY</a><br>   <small>&nbsp; &nbsp; </small><a href=\"index.php?go=tabulatury\" class=menusm>zesp�</a><small> / </small>   <a href=\"index.php?go=tabsolo\" class=menusm>solo</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=zdjecia\" class=menu>GALERIA</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=ciekawostki\" class=menu>CIEKAWOSTKI</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=64><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=download\" class=menu>DOWNLOAD</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=download\" class=menusm>archiwum QC</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=download2\" class=menusm>pliki mp3</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=download3\" class=menusm>pliki MIDI</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=download4\" class=menusm>inne</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=info\" class=menu>REDAKCJA</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=42><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=linki\" class=menu>LINKI</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=linki\" class=menusm>strony polskie</a><br>   <small>&nbsp; > </small><a href=\"index.php?go=linki2\" class=menusm>strony zagraniczne</a><br> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"index.php?go=ankieta\" class=menu>ANKIETA</a> </td></tr><tr height=1><td colspan=2 bgcolor=#cacaca></td></tr> <tr height=18><td bgcolor=#5e5ea4></td><td valign=middle bgcolor=#5e5ea4>  <a href=\"ksiega.php\" class=menu>KSI�GA GO�CI</a>    </td>   </tr>  </table>    </td>   <td width=509 background=\"lay/logo4.gif\" style=\"background-repeat: no-repeat\" valign=top>    <p> <center> &nbsp;<br> <b>NOWE WPISY</b> /  <a href=\"index.php?go=ksiegaarch\"><b>ARCHIWALNE WPISY</b></a> <br><br><br> </center>
";



// Antyspam
$restricted = array ("www","http","href","porn","spyware","gay","price","forum","high","market",
"sex","asian","big","computer","growth","party","large","nice","site","much","more","hot","car",
"pretty","money","free","insurance","new","winner","dollar","million","business","fuck","shit",
"games","make","game","salary","girls","holiday","funny","pictures","product","performance",
"song","greatest","greastest","windows","viagra");
for ( $x=0; $x<count($restricted); $x++ ){
if (eregi($restricted[$x], $_POST['komentarz'])) $c = 1;
}
if (eregi("imiviomozex", $_POST['autor'])) $c = 1;
// Antyspam

if(($_COOKIE[antyflood]!='1') && ($_POST['autor']!="") && ($_POST['komentarz']!="") && ($c!=1))
{
setcookie("antyflood", "1", time()+60*60*24*365*2); // ciasteczko wygasa po 2 latach



echo ($poczatekstrony);



$_POST['autor']=stripslashes($_POST['autor']);
$_POST['email']=stripslashes($_POST['email']);
$_POST['komentarz']=stripslashes($_POST['komentarz']);

$_POST['autor']=ereg_replace("<","&lt;",$_POST['autor']);
$_POST['autor']=ereg_replace(">","&gt;",$_POST['autor']);
$_POST['email']=ereg_replace("<","&lt;",$_POST['email']);
$_POST['email']=ereg_replace(">","&gt;",$_POST['email']);
$_POST['komentarz']=ereg_replace("<","&lt;",$_POST['komentarz']);
$_POST['komentarz']=ereg_replace(">","&gt;", $_POST['komentarz']);

$_POST['komentarz']=ereg_replace("\n","<br>",$_POST['komentarz']);


// SPRAWDZANIE ADRESU IP
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
$ip = $_SERVER["REMOTE_ADDR"];
}
// SPRAWDZANIE ADRESU IP

$plik=fopen("data/ksiega.txt", "a");
fputs($plik,$_POST['autor']."|".$_POST['email']."|".$_POST['komentarz']."|".$_POST['data']."|".$ip."\n");
fclose($plik);

echo("Dzi�kuj�, ".$_POST['autor'].", za wpisanie si� do ksi�gi!<br><br><br>");
echo("<a href=ksiega.php>Powr�t do ksi�gi go�ci</a>");

}

else
{



echo ($poczatekstrony);



if (($_POST['autor']=="") || ($_POST['komentarz']==""))
{
echo("Musisz poda� swoje imi� i komentarz.<br><br><br>");
echo("<a href=\"ksiega.php?action=form\"><b>Powr�t do formularza</b></a>");
}
elseif($c==1)
{
echo("Przykro mi, ale tw�j komentarz nie przeszed� naszej kontroli antyspamowej.<br><br><br>");
echo("<a href=\"ksiega.php?action=form\"><b>Powr�t do formularza</b></a>");
}
elseif($_COOKIE[antyflood]=='1')
{
echo("Mo�na si� wpisa� tylko raz.<br><br><br>");
echo("<a href=ksiega.php>Powr�t do ksi�gi go�ci</a>");
}
else
{
echo("B��d skryptu.<br><br><br>");
echo("<a href=ksiega.php>Powr�t do ksi�gi go�ci</a>");
}


}

ob_end_flush();

?>

<br>&nbsp;
<br>&nbsp;
</p>



  </td>
  <td width=17 background="lay/menu2.gif" style="background-repeat: repeat-y">
  </td>
  <td width=114 background="lay/menu3.gif" style="background-repeat: repeat-y" valign=top>
   <center>
   <a href="http://www.magicqueen.prv.pl" target="_blank">
   <img src="buttonmqmruch.gif" vspace=4 border=0 alt="Magic Queen"></a><br>
<!--
   <a href="http://www.queenonline.pl" target="_blank">
   <img src="button-tsmgo.gif" vspace=0 border=0 alt="www.queenonline.pl"></a><br>
-->
   <a href="http://www.actionmag.net" target="_blank">
   <img src="banneram.gif" vspace=4 border=0 alt="Action Mag"></a><br>
   <br>

   <?php include "sondaform.htm"; ?>

   <code><br>
   <b>KONTAKT &nbsp;</b><br><br>
   w sprawie strony:<br>
   <a href="mailto:wundzunhome@wp.pl" class=sm>wundzunhome@wp.pl</a><br><br>
   adres Queen Corner:<br>
   <a href="mailto:qcorner@poczta.onet.pl" class=sm>qcorner@poczta.onet.pl</a><br><br>
   redaktor naczelny:<br>
   <a href="mailto:chrapek0@poczta.onet.pl" class=sm>chrapek0@poczta.onet.pl</a>
   </code>
   </center>
   </td>
 </tr>
 <tr>
  <td height=22 colspan=4 bgcolor=#cacaca background="lay/stopka.gif" style="background-repeat: no-repeat" align=center>
   <code>&copy; Queen Corner 2002-<?php echo date("Y"); ?></code>
  </td>
</table>


</body>

</html>

