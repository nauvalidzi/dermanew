<?php

namespace PHPMaker2021\Dermatekno;

// Table
$npd_serahterima = Container("npd_serahterima");
?>
<?php if ($npd_serahterima->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npd_serahterimamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($npd_serahterima->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->idpegawai->caption() ?></td>
            <td <?= $npd_serahterima->idpegawai->cellAttributes() ?>>
<span id="el_npd_serahterima_idpegawai">
<span<?= $npd_serahterima->idpegawai->viewAttributes() ?>>
<?= $npd_serahterima->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->idcustomer->caption() ?></td>
            <td <?= $npd_serahterima->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
<span<?= $npd_serahterima->idcustomer->viewAttributes() ?>>
<?= $npd_serahterima->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->tanggal_request->Visible) { // tanggal_request ?>
        <tr id="r_tanggal_request">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->tanggal_request->caption() ?></td>
            <td <?= $npd_serahterima->tanggal_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_request">
<span<?= $npd_serahterima->tanggal_request->viewAttributes() ?>>
<?= $npd_serahterima->tanggal_request->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->tanggal_serahterima->Visible) { // tanggal_serahterima ?>
        <tr id="r_tanggal_serahterima">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->tanggal_serahterima->caption() ?></td>
            <td <?= $npd_serahterima->tanggal_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_serahterima">
<span<?= $npd_serahterima->tanggal_serahterima->viewAttributes() ?>>
<?= $npd_serahterima->tanggal_serahterima->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->jenis_produk->Visible) { // jenis_produk ?>
        <tr id="r_jenis_produk">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->jenis_produk->caption() ?></td>
            <td <?= $npd_serahterima->jenis_produk->cellAttributes() ?>>
<span id="el_npd_serahterima_jenis_produk">
<span<?= $npd_serahterima->jenis_produk->viewAttributes() ?>>
<?= $npd_serahterima->jenis_produk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
