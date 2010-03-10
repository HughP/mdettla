<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="Language" content="pl">
    <meta name="Author" content="Michał Dettlaff">
    <meta name="Copyright" content="Michał Dettlaff 2010">
    <link rel="stylesheet" href="style.css" type="text/css">

    <script>
      function validate_email(email) {
          var atpos = email.indexOf("@");
          var dotpos = email.lastIndexOf(".");
          return atpos >= 1 && dotpos - atpos >= 2;
      }

      function validate_form(form) {
          if (!form.name.value || !form.content.value) {
              alert("Musisz podać imię i treść wpisu.");
              if (!form.name.value) {
                  form.name.focus();
              } else if (!form.content.value) {
                  form.content.focus();
              }
              return false;
          }
          if (form.email.value && !validate_email(form.email.value)) {
              alert("Nieprawidłowy adres email.");
              form.email.focus();
              return false;
          }
      }
    </script>
    <title>Szybkie Pisanie na Klawiaturze</title>
  </head>

  <body link="#7777EE" alink="#7777EE" vlink="#7777EE" bgcolor="#F5F5F5" text="#000001"
      leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="260" valign="top">

          <table align="left" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td rowspan="2" width="32" height="350" valign="top" background="menu1.jpg"
                  bgcolor="#F5F5F5" style="background-repeat: no-repeat">
              </td>
              <td width="228" height="112" valign="top" background="menu2a.jpg"
                  bgcolor="#F5F5F5" style="background-repeat: no-repeat">
              </td>
            </tr>
            <tr>
              <td width="228" height="238" valign="top" background="menu2b.jpg"
                  bgcolor="#f5f5f5" style="background-repeat: no-repeat">
                <a href="index.html" class="menu">Strona główna</a><br />&nbsp;<br />
                <a href="nauka.htm" class="menu">Jak nauczyć się<br />
                  szybkiego pisania?</a><br />&nbsp;<br />
                <a href="programy.php" class="menu">Programy</a><br />&nbsp;<br />
                <a href="test.htm" class="menu">Test prędkości online</a><br />&nbsp;<br />
                <a href="linki.htm" class="menu">Linki</a><br />&nbsp;<br />
                <a href="ksiega.php" class="menu">Księga gości</a><br />&nbsp;<br />
                <a href="autor.htm" class="menu">Autor strony</a>
              </td>
            </tr>
          </table>

        </td>
        <td valign="top">

          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="top" background="menu3.jpg" bgcolor="#F5F5F5"
                  style="background-repeat: no-repeat">

<p>
&nbsp;<br>
<table width="100%">
  <tr bgcolor="#BAC5F8" height="30">
    <td><p class="tytulb">&nbsp; &nbsp;KSIĘGA GOŚCI</p></td>
  </tr>
</table>
<?php

function validate($name, $email, $content) {
    if (strlen($name) > 32 || strlen($email) > 128
            || strlen($content) > 5000) {
        return false;
    }
    $RESTRICTED_WORDS = array(
        "http", "href", "www", "viagra"
    );
    for ($i = 0; $i < count($RESTRICTED_WORDS); $i++) {
        if (eregi($RESTRICTED_WORDS[$i], $content)) {
            return false;
        }
    }
    return true;
}

session_start();

pg_connect("dbname=mdettla user=mdettla password=tommyemmanuel");

if (!empty($_POST['name']) && !empty($_POST['content'])) {
    // dodaj nowy wpis
    $name = pg_escape_string($_POST['name']);
    $email = pg_escape_string($_POST['email']);
    $content = pg_escape_string($_POST['content']);
    echo "<br />\n";
    if ($_SESSION['guestbook_entry_added']) {
        echo "Wielokrotne wpisy nie są dozwolone.\n";
    } else if (validate($name, $email, $content)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ip = pg_escape_string($ip);
        pg_query("
            INSERT INTO guestbook
                (date_added, ip, username, email, content)
                VALUES
                (NOW(), '$ip', '$name', '$email', '$content')
        ");
        echo "Twój wpis został dodany.\n";
        $_SESSION['guestbook_entry_added'] = true;
    } else {
        echo "Przykro mi, ale twój wpis nie został zaakceptowany.\n";
    }
    echo "<br /><br />\n";
    echo "<a href=\"\"><b>Powrót do księgi gości</b></a>\n";
} else {
?>
<table width="100%">
  <tr>
    <td>
      <p>Jeśli chcesz wyrazić swoją opinię o tej stronie lub na temat
          z nią związany - wpisz się!</p>
    </td>
  </tr>
</table>
<form action="" method="POST" onSubmit="return validate_form(this)">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td align="right"><b>*Imię:</b></td>
      <td width="95%"><input type="text" name="name" maxlength="32"><br></td>
    </tr>
    <tr>
      <td align="right"><b>email:</b></td>
      <td><input type="text" name="email" maxlength="128"><br></td>
    </tr>
    <tr>
      <td align="right" valign="top"><b>*Treść&nbsp;wpisu:</b></td>
      <td><textarea name="content" rows=2 cols=50 wrap="physical"></textarea><br></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size: 8pt">* - pole wymagane</td>
    </tr>
    <tr bgcolor="#bac5f8" height=30>
      <td></td>
      <td>
        <input type="submit" name="zapisz" value="     zapisz      ">&nbsp;&nbsp;
        <input type="reset" name="wyczysc" value="     wyczyść     ">
      </td>
    </tr>
  </table>
</form>

<?php
    // pokaż księgę gości
    $PAGE_SIZE = 20;
    if (is_numeric($_GET['page']) && $_GET['page'] > 0) {
        $current_page = $_GET['page'];
    } else {
        $current_page = 1;
    }
    $result = pg_query("
        SELECT date_added, username, email, content
            FROM guestbook
            ORDER BY date_added DESC
            LIMIT $PAGE_SIZE
            OFFSET " . ($PAGE_SIZE * ($current_page - 1)) . "
    ");
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            if (!empty($row['email'])) {
                echo "<a href=\"mailto:"
                    . htmlspecialchars($row['email']) . "\"><b>";
                echo htmlspecialchars($row['username']) . "</b></a>\n";
            } else {
                echo '<b>' . htmlspecialchars($row['username']) . '</b> ';
            }
            $date = date("d.m.Y", strtotime($row['date_added']));
            $time = date("H:i", strtotime($row['date_added']));
            echo "napisał(a) dnia $date";
            if ($time != "00:00") {
                echo " o godzinie $time\n";
            }
            echo "<br /><br />\n";
            echo str_replace("\n", "<br>\n",
                htmlspecialchars($row['content']));
            echo "\n<br /><br />\n<hr />\n\n";
        }
        // stronicowanie
        $result = pg_query("
            SELECT COUNT(id_guestbook) AS guestbook_size FROM guestbook
        ");
        if ($result && ($row = pg_fetch_assoc($result))) {
            $total_guestbook_size = $row['guestbook_size'];
            $page_count = (int)((($total_guestbook_size - 1) / $PAGE_SIZE) + 1);
            echo "<br />\n<div style=\"text-align: center\">\n";
            if ($current_page > 1) {
                echo "<a href=\"?page=" . ($current_page - 1)
                    . "\"><b>&larr; </b></a>\n";
            } else {
                echo "<b>&larr; </b>\n";
            }
            for ($i = 1; $i <= $page_count; $i++) {
                if ($i == $current_page) {
                    echo "$i\n";
                } else {
                    echo "<a href=\"?page=$i\"><b>$i</b></a>\n";
                }
            }
            if ($current_page <= $page_count) {
                echo "<a href=\"?page=" . ($current_page + 1)
                    . "\"><b>&rarr; </b></a>\n";
            } else {
                echo "<b>&rarr; </b>\n";
            }
            echo "</div>\n";
        }
    }
}

?>

<br />
<br />&nbsp;
</p>

            </td>
            <td width="25"></td>
            </tr>
          </table>

        </td>
      </tr>
    </table>

  </body>
</html>
