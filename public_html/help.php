<?php

include_once('inc.auth.php');
include_once('inc.header.php');

if (isset($_SESSION['angemeldet'])){
?>

<div class="container"><div class="row">
<h2>Helping Hand for easyBM Web Control</h2>
<h3>Content</h3>

<a href="#nutzung" type="button" class="btn btn-default btn-xs">Nutzung</a>
<a href="#flow" type="button" class="btn btn-default btn-xs">Flow Chart</a>
<a href="#rollen" type="button" class="btn btn-default btn-xs">Rollen</a>
<a href="#dashboard" type="button"   class="btn btn-default btn-xs">Dashboard</a>
<a href="#servicetest" type="button" class="btn btn-default btn-xs">Servicetest</a>
<a href="#testcases" type="button"   class="btn btn-default btn-xs">Testcase</a>
<a href="#testdocu" type="button"    class="btn btn-default btn-xs">Testdocu</a>
<a href="#note" type="button"    class="btn btn-default btn-xs">Note</a>
<a href="#url" type="button"    class="btn btn-default btn-xs">URL</a>
<a href="#attachement" type="button"    class="btn btn-default btn-xs">Attachement</a>
<a href="#modified" type="button"    class="btn btn-default btn-xs">Modified</a>
<a href="#functions" type="button"    class="btn btn-default btn-xs">Functions</a>

<hr>

<h4><a name="vorwort">Vorwort</a></h3>
<p class="text-left">Diese Regression Test DB wurde auf der Idee von Torsten Jedicke, TONP  und durch Stephan Miersch, TONR sowie Klaus Froese, TONR umgesetzt.  Fragen sollten zun&auml;chst im eigenen Team gekl&auml;rt oder an weitere Nutzer adressiert werden.  </p>
<p class="text-left">Die Regession Test Datenbank versteht sich als Hilfe bei Changes, bei denen Tests notwendig sind.  So werden notwendige Tests aufgef&uuml;hrt und als Arbeitsanweisung beschrieben. Auch wird der Vorgang des Testens als solches dokumentiert.  </p> 

<h4><a name="Nutzung">Vorraussetung</a></h4>
<p class="text-left"><b>User:</b>Um die Regression Test DB korrekt benutzen zu k&ouml;nnen, ist der Login im OSS-Portal erforderlich.  Als Web-Browser empfiehlt sich der Firefox-Browser in einer aktuellen Version. Bei anderen wird eine Warnung am obeneren Fensterrand zu sehen sein, die keine weitere Auswirkung hat. Der Internet-Explorer kleiner Version 9 wird nicht unterst&uuml;tzt, da die Webseite auf JavaScript und teilweise HTML5 aufbaut.  </p>

<p class="text-left"><b>Server:</b>Die Regression Test DB nutzt die Technologieen HTML, PHP5, JavaScript, MySQL. So wir ein entsprechender Webserver ben&ouml;tigt, der dies zur Verf&uuml;gung stellt. Aktuell nutzen wir dazu einen virtuellen Server im OSS-Portal Umfeld, auf den wir mittel SSH zugriff haben.  Als Server OS kommt CentOS zum Einsatz.  </p>

<h4><a name="Nutzung">Nutzung</a></h4>
<p class="text-left">Im folgenden wird die grunds&auml;tzliche Nutzung kurz beschrieben. Die Nutzung ist selbsterkl&auml;rend und orientiert sich an den bisherigen manuellen Ablauf. Neu ist, das Testdokumente nicht mehr auf dem eigenem PC oder auf einem Netzlaufwerk gespeichert werden, sondern in dieser vorliegenden Regeressen Test Datenbank. Neu ist auch, dass nach dem durchgef&uuml;hrten Test, das Ergebnis als &uuml;bersichtliches einheitliches Formblatts in Form einer PDF-Datei zur verf&uuml;gung steht. Diese Datei wird weiter auf einer revisions sicherem Laufwerk gespeichert.  <small>(Zum April 2015 stand der endg&uuml;ltige Speicherort daf&uuml;r noch nicht fest)</small>.  
<br>
Der Teilprojektleiter ist Angehalten die Regression Test Datenbank mit den entsprechen Daten zu f&uuml;llen und zu nutzen.  Es sind etwa drei Schritte notwendig um ein PDF-File f&uuml;r den RFC erzeugen zu k&ouml;nnen.
<ul>
<li>Die Test-Prozedur, muss vorhanden sein oder neu angelegt werden</li>
<li>Der Testcase muss angelegt sein, damit ist die Verkn&uuml;pfung von
Standort, System und dem Test gemeint</li>
<li>Das Test-Document wird auf Basis des TWOS RFCs <i>(Request for
change)</i> in der Regessen Test DB angelegt und dort gepflegt.</li>
<li>Wurden alle Schritte durchlaufen und festgehalten, kann -nach dem der
RFC in den Status Implementet gesetzt wurde- das Ergebnis des Tests als PDF
Dokument erzeugt werden und auf dem lokalen PC gespeichert werden.</li>
<li>Die erzeugte PDF-Datei wird dann in der <a
href="http://de.wikipedia.org/wiki/Revisionssicherheit"
target=_blank">revisons sicheren</a> Ablage gespeichert.</li>
</ul>

<b>Hinweise</b> sind als interaktive farbige Fl&auml;chen auf der Webseite
zu erkennen. Diese informieren den User &uuml;ber erfolgreiche oder nicht
erfolgreiche Vorg&auml;nge.
Zudem werden Vorgänge in ein Logbuch eingetragen, diese kann man &uuml;ber
den Button -History- einsehen.


</p>

<h4><a name="flow">Flow Chart</a></h4>
<p class="text-left"> Schau dir auch dazu die <a href="https://" target="_blank">Prozessbeschreinung</a> in PIP an.  </p>
<p class="text-left">
        <ol>
         <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner legt RFC in Champs an </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner erstellt Docu in der RTDB </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner informiert Tester </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Deployer f&uuml;hrt Change durch </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Tester Inbetriebnahme informiert den Changeowner </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner aktuallisiert die RGTDB </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner setzt RFC-Status in RTDB </li><br>
     <li><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Changeowner speichert PRE und POST Test Dokumentation im Workspace</li><br>
     </ol>
</p>

<h4><a name="dashboard">Dashboard</a></h4>
<p class="text-left">Das Dashboard stellt die Startseite der Regression Test
Datenbank dar. Sie dient als zentraler Einstiegspunkt und beheimatet alle
Funktionen.</p>
<p class="text-left">So ist rechts Oben die globale Navigation zu finden.
        <b>AIO Home</b> f&uuml;hrt dich zur&uuml;ck auf die Startseite der
AIO im OSS-Portal.
        <b>Dashboard</b> zeigt die Startseite der Regession Test DB.
        <b>Userprofil</b> dient lediglich dazu, sein eigenes Profil des
OSS-Portal anzuzeigen. Damit kann auch gepr&uuml;ft werden ob der OSS-Portal
Login weiterhin g&uuml;ltig ist.
        <b>Help</b> zeigt diesen Hilfetext an, und versteht sich als
einfache Gedankenst&uuml;tze f&uuml;r die Nutzer.
        <b>History</b> ist eine n&uuml;tzliche Auflistung es intern
erzeugten Logs. Damit k&ouml;nnen Ver&auml;nderungen in der Regression Test
DB nachvollzogen werden.
</p>

<h4><a name="location">Location</a></h4>
<p class="text-left">Als Location ist der Standort des Netzelements  bzw.  Systems zu verstehen. Wir kennen unter anderem rn, fkft, mnch, hmbg, brln etc.</p>

<h4><a name="networkelement">Networkelement</a></h4>
<p class="text-left">Als Bezeichnung eines Networkelement nuten wir meist einen Teil des Hostnamens, da sich zum Beispiel die Testanweisung nicht auf ein einzelnes Netzelement bezieht, sonder auf eine Gruppe gleichartiger.  Deshalb wir der Teil OUMFW aus dem Hostnamen MNCH8OUMFW678 verwendet und benennt damit alle OuM Firewalls gleicher Bauart.  </p>

<h4><a name="comment">Comment</a></h4>
<p class="text-left">In diesem Feld kann optional ein Kommentar zu einer neuen Networkelement Gruppe an einem bestimmten Standort angegeben. Dies ist weiter nicht von relevanz.</p>

<h4><a name="id">ID</a></h4>
<p class="text-left">Teilweise wurde in tabellarischen Auflistungen die ID des Datenbank eintrags mit angezeigt. Dies dient lediglich zur besseren Orintierung.</p>


<h4><a name="component">Component</a></h4>
<p class="text-left"> uf</p>

<h4><a name="release">Release</a></h4>
<p class="text-left"> aktuelle Software Version des Netzelementes bzw. des zu testenden Systems.</p>

<h4><a name="changeowner">Change Owner</a></h4>
<p class="text-left"> Der Name des Change-Erstellers. Also diejenige Person, welche den Change verantwortet. </p>

<h4><a name="vendor">Vendor</a></h4>
<p class="text-left">Bezeichnet den Lieferanten oder Hersteller des zu testenden Systems</p>

<h4><a name="taccqa">TACC/QA</a></h4>
<p class="text-left"> Names des verantwortlichen f&uuml;r die TACC und des
Quality Approvals.</p>

<h4><a name="implementer">Implementer</a></h4>
<p class="text-left">Name der Person, die den Change durchf&uuml;hrt bzw.  implementiert.</p>


<h4><a name="rfcid">RFC-ID</a></h4>
<p class="text-left">Die in TTWOS definiert eindeutige ID, ist meist eine Nummer.</p>


<h4><a name="rfcsubject">RFC-Subject</a></h4>
<p class="text-left"> Kurzbeschreibung des Changes.</p>

<h4><a name="rfcstatus">RFC-Status</a></h4>
<p class="text-left"> Bietet eine Auswahl&ouml;glichkeit an, wie man es aus Champs kennt. Es beschreibt den aktuellen Status des RFCs.  Wie zum Beispiel 'Announced','Requested','Registered','Authorized','partly Implemented','Implemented','Canceled' </p>

<h4><a name="rfctype">RFC-Type</a></h4>
<p class="text-left">Beeinhaltet die Art des Changes z.Bsp: "Configuration/Workorder" oder "System Administration", "Incident Management" usw. </p>

<h4><a name="unused">Unused</a></h4>
<p class="text-left">Sollte in einem speziellen Fall, ein Test nicht notwendig sein, so kann dieser f&uuml;r den einzelfall deaktiviert werden.  Dennoch wir dieser deaktivierte Test im abschliessenden PDF-Formblatt ausgegraut angezeigt.</p>

<h4><a name="pretest">Pretest</a></h4>
<p class="text-left">War der Vortest erfolgreich, wird hier ein Hacken gesetzt.</p>


<h4><a name="posttest">Postest</a></h4>
<p class="text-left">War der Nachtest erfolgreich, wird hier ein Hacken gesetzt.</p>



<hr>

<p class="text-center muted">
        <small>Created and maintained by BrandMeister Team Germany, Sep 2016</small>
</p>



</div></div>

<?php
} else { echo pleaseLogin(); }
include_once('inc.footer.php');
?>
