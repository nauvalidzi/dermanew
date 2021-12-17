<?php

namespace PHPMaker2021\Dermatekno;

// Page object
$PerizinanHkiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fperizinan_hkiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fperizinan_hkiview = currentForm = new ew.Form("fperizinan_hkiview", "view");
    loadjs.done("fperizinan_hkiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.perizinan_hki) ew.vars.tables.perizinan_hki = <?= JsonEncode(GetClientVar("tables", "perizinan_hki")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperizinan_hkiview" id="fperizinan_hkiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perizinan_hki">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_perizinan_hki_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_order->Visible) { // no_order ?>
    <tr id="r_no_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_no_order"><?= $Page->no_order->caption() ?></span></td>
        <td data-name="no_order" <?= $Page->no_order->cellAttributes() ?>>
<span id="el_perizinan_hki_no_order">
<span<?= $Page->no_order->viewAttributes() ?>>
<?= $Page->no_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_perizinan_hki_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_perizinan_hki_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
    <tr id="r_tanggal_terima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_tanggal_terima"><?= $Page->tanggal_terima->caption() ?></span></td>
        <td data-name="tanggal_terima" <?= $Page->tanggal_terima->cellAttributes() ?>>
<span id="el_perizinan_hki_tanggal_terima">
<span<?= $Page->tanggal_terima->viewAttributes() ?>>
<?= $Page->tanggal_terima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <tr id="r_tanggal_submit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_tanggal_submit"><?= $Page->tanggal_submit->caption() ?></span></td>
        <td data-name="tanggal_submit" <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el_perizinan_hki_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <tr id="r_ktp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_ktp"><?= $Page->ktp->caption() ?></span></td>
        <td data-name="ktp" <?= $Page->ktp->cellAttributes() ?>>
<span id="el_perizinan_hki_ktp">
<span<?= $Page->ktp->viewAttributes() ?>>
<?= $Page->ktp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <tr id="r_npwp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_npwp"><?= $Page->npwp->caption() ?></span></td>
        <td data-name="npwp" <?= $Page->npwp->cellAttributes() ?>>
<span id="el_perizinan_hki_npwp">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= $Page->npwp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
    <tr id="r_nib">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_nib"><?= $Page->nib->caption() ?></span></td>
        <td data-name="nib" <?= $Page->nib->cellAttributes() ?>>
<span id="el_perizinan_hki_nib">
<span<?= $Page->nib->viewAttributes() ?>>
<?= $Page->nib->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
    <tr id="r_akta_pendirian">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_akta_pendirian"><?= $Page->akta_pendirian->caption() ?></span></td>
        <td data-name="akta_pendirian" <?= $Page->akta_pendirian->cellAttributes() ?>>
<span id="el_perizinan_hki_akta_pendirian">
<span<?= $Page->akta_pendirian->viewAttributes() ?>>
<?= $Page->akta_pendirian->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->surat_umk->Visible) { // surat_umk ?>
    <tr id="r_surat_umk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_surat_umk"><?= $Page->surat_umk->caption() ?></span></td>
        <td data-name="surat_umk" <?= $Page->surat_umk->cellAttributes() ?>>
<span id="el_perizinan_hki_surat_umk">
<span<?= $Page->surat_umk->viewAttributes() ?>>
<?= $Page->surat_umk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
    <tr id="r_ttd_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_ttd_pemohon"><?= $Page->ttd_pemohon->caption() ?></span></td>
        <td data-name="ttd_pemohon" <?= $Page->ttd_pemohon->cellAttributes() ?>>
<span id="el_perizinan_hki_ttd_pemohon">
<span<?= $Page->ttd_pemohon->viewAttributes() ?>>
<?= $Page->ttd_pemohon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_merk->Visible) { // nama_merk ?>
    <tr id="r_nama_merk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_nama_merk"><?= $Page->nama_merk->caption() ?></span></td>
        <td data-name="nama_merk" <?= $Page->nama_merk->cellAttributes() ?>>
<span id="el_perizinan_hki_nama_merk">
<span<?= $Page->nama_merk->viewAttributes() ?>>
<?= $Page->nama_merk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_merk->Visible) { // label_merk ?>
    <tr id="r_label_merk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_label_merk"><?= $Page->label_merk->caption() ?></span></td>
        <td data-name="label_merk" <?= $Page->label_merk->cellAttributes() ?>>
<span id="el_perizinan_hki_label_merk">
<span<?= $Page->label_merk->viewAttributes() ?>>
<?= $Page->label_merk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_deskripsi->Visible) { // label_deskripsi ?>
    <tr id="r_label_deskripsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_label_deskripsi"><?= $Page->label_deskripsi->caption() ?></span></td>
        <td data-name="label_deskripsi" <?= $Page->label_deskripsi->cellAttributes() ?>>
<span id="el_perizinan_hki_label_deskripsi">
<span<?= $Page->label_deskripsi->viewAttributes() ?>>
<?= $Page->label_deskripsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unsur_warna->Visible) { // unsur_warna ?>
    <tr id="r_unsur_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_unsur_warna"><?= $Page->unsur_warna->caption() ?></span></td>
        <td data-name="unsur_warna" <?= $Page->unsur_warna->cellAttributes() ?>>
<span id="el_perizinan_hki_unsur_warna">
<span<?= $Page->unsur_warna->viewAttributes() ?>>
<?= $Page->unsur_warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perizinan_hki_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_perizinan_hki_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
