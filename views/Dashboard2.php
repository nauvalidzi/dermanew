<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$Dashboard2 = &$Page;
?>
<?php
$piutangs = ExecuteQuery("SELECT * FROM d_jatuhtempo WHERE (idpegawai=".CurrentUserID()." OR idpegawai IN (SELECT id FROM pegawai WHERE pid=".CurrentUserID().")) AND sisahari<7 ORDER BY sisahari")->fetchAll();
?>

<h4>Jatuh Tempo Minggu Ini & Lewat</h4>

<table class="table ew-table">
    <thead>
        <tr class="ew-table-header">
            <th>Marketing</th>
            <th>Customer</th>
            <th>Kode Invoice</th>
            <th>Sisa Bayar</th>
            <th>Jatuh Tempo</th>
        </tr>
    </thead>

    <tbody>
    	<?php
    	if (count($piutangs) > 0) {
    		foreach ($piutangs as $piutang) {
    	?>
    	<tr>
            <td><?= $piutang['namapegawai'] ?></td>
            <td><?= $piutang['namacustomer'] ?></td>
            <td><?= $piutang['kodeinvoice'] ?></td>
            <td>Rp. <?= number_format($piutang['sisabayar']) ?></td>
            <?php
            $tempo = "";
            switch($piutang['sisahari']) {
            	case -1: $tempo = "Kemarin"; break;
            	case 0: $tempo = "Hari ini"; break;
            	case 1: $tempo = "Besok"; break;
            	case 2: $tempo = "Lusa"; break;
            	default: $tempo = date("d M Y", strtotime($piutang['jatuhtempo']));;
            }
            ?>
            <td><?= $tempo ?></td>
        </tr>
    	<?php
    		}
    	} else {
    	?>
    		<tr>
    			<td colspan=5>Tidak ada data.</td>
    		</tr>
    	<?php
    	}
        ?>
    </tbody>

    <!-- <tfoot>
        <tr class="ew-table-footer">
            <# if (linkOnLeft) { #>
            {{{list_options}}}
            <# } #>
            <# for (let f of currentFields) { #>
            <td>{{{<#= f.FldParm #>}}}</td>
            <# } #>
            <# if (!linkOnLeft) { #>
            {{{list_options}}}
            <# } #>
        </tr>
    </tfoot> -->
</table>


<?= GetDebugMessage() ?>
