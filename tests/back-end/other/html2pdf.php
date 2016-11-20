<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 16/11/16
 * Time: 21:40
 */


include '../../../private/library/other/html2pdf.php';

ob_start();
?>
<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .big{
        font-size: 30px;
        font-weight: bold;
    }
    .upcase{
        text-transform: uppercase;
    }
    .little{
        font-size: 15px;
        font-weight: 100;
    }
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .vMiddle{
        vertical-align: middle;
    }
    .mark{
        font-size: 25px;
    }
    -->
</style>
<page backcolor="#FEFEFE" backimgx="center" backimgy="bottom" backimgw="100%" backtop="10mm" backbottom="30mm" backleft="10mm" footer="date;heure;page" style="font-size: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <td rowspan="6" style="width:50%; ">
                <qrcode value="gestion-stage.eu/index.php?p=show_answers&id=A2HGHHSIA3XC" c="L" style="border: none; width: 40mm;"></qrcode>
            </td>
            <td style="width:50%;" colspan="2" class="big">Valentin <span class="upcase">Lacour</span><br><span class="little">Groupe A</span></td>
        </tr>
        <tr>
            <td style="width:14%; "><b>Adresse :</b></td>
            <td style="width:36%">
                Résidence perdue<br>
                1, rue sans nom<br>
                00 000 - Pas de Ville<br>
            </td>
        </tr>
        <tr>
            <td style="width:14%; "><b>Email :</b></td>
            <td style="width:36%">nomail@domain.com</td>
        </tr>
        <tr>
            <td style="width:14%; "><b>Tel :</b></td>
            <td style="width:36%">33 (0) 1 00 00 00 00</td>
        </tr>
        <tr>
            <td style="width:14%; "><b>Tuteur Entreprise :</b></td>
            <td style="width:36%">Jean-Francois Lapiche</td>
        </tr>
        <tr>
            <td style="width:14%; "><b>Tuteur IUT :</b></td>
            <td style="width:36%">Christophe Logé</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <col style="width: 5%">
        <col style="width: 75%;">
        <col style="width: 20%;">
        <thead>
        <tr>
            <th>Numéro Question</th>
            <th></th>
            <th class="text-center">Note</th>
        </tr>
        </thead>
        <?php
            for($i=1;$i<7;$i++) {
                ?>
                <tr>
                    <td class="text-center"><h4 class="fw-semi-bold mt-n"><?php echo $i; ?>-</h4></td>
                    <td class="text-center">
                        <h3> Rémi Lemaire a t'il fait preuve d'assiduité durant son stage?</h3>

                        <p class="text-center"><b>Oui</b> &nbsp; &bull; &nbsp; Non &nbsp; &bull; &nbsp; Autre</p>
                        <?php if($i%2 == 1){?>
                        <h5> COMMENTAIRE ICI -- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere
                            erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                            ante.</h5>
                        <?php } ?>
                    </td>
                    <td class="vMiddle text-center"><b class="mark"><?php echo rand(0,5); ?></b>/5</td>
                </tr>
            <?php
            }
        ?>
        <tr>
            <td colspan="3">&nbsp;<br><br></td>
        </tr>
        <tr>
            <td colspan="2" class="text-right big">
                <b>Total :</b>
            </td>
            <td class="text-center"><span class="big">15</span>/20</td>
        </tr>
    </table>
</page>
<?
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', 'A4', 'fr');
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->writeHTML($content);
$datas = $html2pdf->Output('test.pdf');