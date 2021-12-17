<?php

namespace PHPMaker2021\Dermatekno;

// Page object
$PerizinanHkiList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fperizinan_hkilist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fperizinan_hkilist = currentForm = new ew.Form("fperizinan_hkilist", "list");
    fperizinan_hkilist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fperizinan_hkilist");
});
var fperizinan_hkilistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fperizinan_hkilistsrch = currentSearchForm = new ew.Form("fperizinan_hkilistsrch");

    // Dynamic selection lists

    // Filters
    fperizinan_hkilistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fperizinan_hkilistsrch");
});
</script>
<style>
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fperizinan_hkilistsrch" id="fperizinan_hkilistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fperizinan_hkilistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="perizinan_hki">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> perizinan_hki">
<form name="fperizinan_hkilist" id="fperizinan_hkilist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perizinan_hki">
<div id="gmp_perizinan_hki" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_perizinan_hkilist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_perizinan_hki_id" class="perizinan_hki_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->no_order->Visible) { // no_order ?>
        <th data-name="no_order" class="<?= $Page->no_order->headerCellClass() ?>"><div id="elh_perizinan_hki_no_order" class="perizinan_hki_no_order"><?= $Page->renderSort($Page->no_order) ?></div></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Page->idpegawai->headerCellClass() ?>"><div id="elh_perizinan_hki_idpegawai" class="perizinan_hki_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_perizinan_hki_idcustomer" class="perizinan_hki_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <th data-name="tanggal_terima" class="<?= $Page->tanggal_terima->headerCellClass() ?>"><div id="elh_perizinan_hki_tanggal_terima" class="perizinan_hki_tanggal_terima"><?= $Page->renderSort($Page->tanggal_terima) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <th data-name="tanggal_submit" class="<?= $Page->tanggal_submit->headerCellClass() ?>"><div id="elh_perizinan_hki_tanggal_submit" class="perizinan_hki_tanggal_submit"><?= $Page->renderSort($Page->tanggal_submit) ?></div></th>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
        <th data-name="ktp" class="<?= $Page->ktp->headerCellClass() ?>"><div id="elh_perizinan_hki_ktp" class="perizinan_hki_ktp"><?= $Page->renderSort($Page->ktp) ?></div></th>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
        <th data-name="npwp" class="<?= $Page->npwp->headerCellClass() ?>"><div id="elh_perizinan_hki_npwp" class="perizinan_hki_npwp"><?= $Page->renderSort($Page->npwp) ?></div></th>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
        <th data-name="nib" class="<?= $Page->nib->headerCellClass() ?>"><div id="elh_perizinan_hki_nib" class="perizinan_hki_nib"><?= $Page->renderSort($Page->nib) ?></div></th>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
        <th data-name="akta_pendirian" class="<?= $Page->akta_pendirian->headerCellClass() ?>"><div id="elh_perizinan_hki_akta_pendirian" class="perizinan_hki_akta_pendirian"><?= $Page->renderSort($Page->akta_pendirian) ?></div></th>
<?php } ?>
<?php if ($Page->surat_umk->Visible) { // surat_umk ?>
        <th data-name="surat_umk" class="<?= $Page->surat_umk->headerCellClass() ?>"><div id="elh_perizinan_hki_surat_umk" class="perizinan_hki_surat_umk"><?= $Page->renderSort($Page->surat_umk) ?></div></th>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
        <th data-name="ttd_pemohon" class="<?= $Page->ttd_pemohon->headerCellClass() ?>"><div id="elh_perizinan_hki_ttd_pemohon" class="perizinan_hki_ttd_pemohon"><?= $Page->renderSort($Page->ttd_pemohon) ?></div></th>
<?php } ?>
<?php if ($Page->nama_merk->Visible) { // nama_merk ?>
        <th data-name="nama_merk" class="<?= $Page->nama_merk->headerCellClass() ?>"><div id="elh_perizinan_hki_nama_merk" class="perizinan_hki_nama_merk"><?= $Page->renderSort($Page->nama_merk) ?></div></th>
<?php } ?>
<?php if ($Page->label_merk->Visible) { // label_merk ?>
        <th data-name="label_merk" class="<?= $Page->label_merk->headerCellClass() ?>"><div id="elh_perizinan_hki_label_merk" class="perizinan_hki_label_merk"><?= $Page->renderSort($Page->label_merk) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_perizinan_hki_created_at" class="perizinan_hki_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_perizinan_hki", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_order->Visible) { // no_order ?>
        <td data-name="no_order" <?= $Page->no_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_no_order">
<span<?= $Page->no_order->viewAttributes() ?>>
<?= $Page->no_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <td data-name="tanggal_terima" <?= $Page->tanggal_terima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_tanggal_terima">
<span<?= $Page->tanggal_terima->viewAttributes() ?>>
<?= $Page->tanggal_terima->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit" <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ktp->Visible) { // ktp ?>
        <td data-name="ktp" <?= $Page->ktp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_ktp">
<span<?= $Page->ktp->viewAttributes() ?>>
<?= $Page->ktp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->npwp->Visible) { // npwp ?>
        <td data-name="npwp" <?= $Page->npwp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_npwp">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= $Page->npwp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nib->Visible) { // nib ?>
        <td data-name="nib" <?= $Page->nib->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_nib">
<span<?= $Page->nib->viewAttributes() ?>>
<?= $Page->nib->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
        <td data-name="akta_pendirian" <?= $Page->akta_pendirian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_akta_pendirian">
<span<?= $Page->akta_pendirian->viewAttributes() ?>>
<?= $Page->akta_pendirian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->surat_umk->Visible) { // surat_umk ?>
        <td data-name="surat_umk" <?= $Page->surat_umk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_surat_umk">
<span<?= $Page->surat_umk->viewAttributes() ?>>
<?= $Page->surat_umk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
        <td data-name="ttd_pemohon" <?= $Page->ttd_pemohon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_ttd_pemohon">
<span<?= $Page->ttd_pemohon->viewAttributes() ?>>
<?= $Page->ttd_pemohon->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_merk->Visible) { // nama_merk ?>
        <td data-name="nama_merk" <?= $Page->nama_merk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_nama_merk">
<span<?= $Page->nama_merk->viewAttributes() ?>>
<?= $Page->nama_merk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->label_merk->Visible) { // label_merk ?>
        <td data-name="label_merk" <?= $Page->label_merk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_label_merk">
<span<?= $Page->label_merk->viewAttributes() ?>>
<?= $Page->label_merk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("perizinan_hki");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
