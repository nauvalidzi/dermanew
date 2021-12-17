<?php

namespace PHPMaker2021\Dermatekno;

// Page object
$PerizinanHkiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fperizinan_hkiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fperizinan_hkiedit = currentForm = new ew.Form("fperizinan_hkiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "perizinan_hki")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.perizinan_hki)
        ew.vars.tables.perizinan_hki = currentTable;
    fperizinan_hkiedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["no_order", [fields.no_order.visible && fields.no_order.required ? ew.Validators.required(fields.no_order.caption) : null], fields.no_order.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null, ew.Validators.integer], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["tanggal_terima", [fields.tanggal_terima.visible && fields.tanggal_terima.required ? ew.Validators.required(fields.tanggal_terima.caption) : null, ew.Validators.datetime(0)], fields.tanggal_terima.isInvalid],
        ["tanggal_submit", [fields.tanggal_submit.visible && fields.tanggal_submit.required ? ew.Validators.required(fields.tanggal_submit.caption) : null, ew.Validators.datetime(0)], fields.tanggal_submit.isInvalid],
        ["ktp", [fields.ktp.visible && fields.ktp.required ? ew.Validators.required(fields.ktp.caption) : null], fields.ktp.isInvalid],
        ["npwp", [fields.npwp.visible && fields.npwp.required ? ew.Validators.required(fields.npwp.caption) : null], fields.npwp.isInvalid],
        ["nib", [fields.nib.visible && fields.nib.required ? ew.Validators.required(fields.nib.caption) : null], fields.nib.isInvalid],
        ["akta_pendirian", [fields.akta_pendirian.visible && fields.akta_pendirian.required ? ew.Validators.required(fields.akta_pendirian.caption) : null], fields.akta_pendirian.isInvalid],
        ["surat_umk", [fields.surat_umk.visible && fields.surat_umk.required ? ew.Validators.required(fields.surat_umk.caption) : null], fields.surat_umk.isInvalid],
        ["ttd_pemohon", [fields.ttd_pemohon.visible && fields.ttd_pemohon.required ? ew.Validators.required(fields.ttd_pemohon.caption) : null], fields.ttd_pemohon.isInvalid],
        ["nama_merk", [fields.nama_merk.visible && fields.nama_merk.required ? ew.Validators.required(fields.nama_merk.caption) : null], fields.nama_merk.isInvalid],
        ["label_merk", [fields.label_merk.visible && fields.label_merk.required ? ew.Validators.required(fields.label_merk.caption) : null], fields.label_merk.isInvalid],
        ["label_deskripsi", [fields.label_deskripsi.visible && fields.label_deskripsi.required ? ew.Validators.required(fields.label_deskripsi.caption) : null], fields.label_deskripsi.isInvalid],
        ["unsur_warna", [fields.unsur_warna.visible && fields.unsur_warna.required ? ew.Validators.required(fields.unsur_warna.caption) : null], fields.unsur_warna.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fperizinan_hkiedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fperizinan_hkiedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fperizinan_hkiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fperizinan_hkiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fperizinan_hkiedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperizinan_hkiedit" id="fperizinan_hkiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perizinan_hki">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_perizinan_hki_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_perizinan_hki_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="perizinan_hki" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_order->Visible) { // no_order ?>
    <div id="r_no_order" class="form-group row">
        <label id="elh_perizinan_hki_no_order" for="x_no_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_order->caption() ?><?= $Page->no_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_order->cellAttributes() ?>>
<span id="el_perizinan_hki_no_order">
<input type="<?= $Page->no_order->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_no_order" name="x_no_order" id="x_no_order" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->no_order->getPlaceHolder()) ?>" value="<?= $Page->no_order->EditValue ?>"<?= $Page->no_order->editAttributes() ?> aria-describedby="x_no_order_help">
<?= $Page->no_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_perizinan_hki_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_perizinan_hki_idpegawai">
<input type="<?= $Page->idpegawai->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_idpegawai" name="x_idpegawai" id="x_idpegawai" size="30" placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>" value="<?= $Page->idpegawai->EditValue ?>"<?= $Page->idpegawai->editAttributes() ?> aria-describedby="x_idpegawai_help">
<?= $Page->idpegawai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_perizinan_hki_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_perizinan_hki_idcustomer">
<input type="<?= $Page->idcustomer->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_idcustomer" name="x_idcustomer" id="x_idcustomer" size="30" placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>" value="<?= $Page->idcustomer->EditValue ?>"<?= $Page->idcustomer->editAttributes() ?> aria-describedby="x_idcustomer_help">
<?= $Page->idcustomer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
    <div id="r_tanggal_terima" class="form-group row">
        <label id="elh_perizinan_hki_tanggal_terima" for="x_tanggal_terima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_terima->caption() ?><?= $Page->tanggal_terima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_terima->cellAttributes() ?>>
<span id="el_perizinan_hki_tanggal_terima">
<input type="<?= $Page->tanggal_terima->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_tanggal_terima" name="x_tanggal_terima" id="x_tanggal_terima" placeholder="<?= HtmlEncode($Page->tanggal_terima->getPlaceHolder()) ?>" value="<?= $Page->tanggal_terima->EditValue ?>"<?= $Page->tanggal_terima->editAttributes() ?> aria-describedby="x_tanggal_terima_help">
<?= $Page->tanggal_terima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_terima->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_terima->ReadOnly && !$Page->tanggal_terima->Disabled && !isset($Page->tanggal_terima->EditAttrs["readonly"]) && !isset($Page->tanggal_terima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fperizinan_hkiedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fperizinan_hkiedit", "x_tanggal_terima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <div id="r_tanggal_submit" class="form-group row">
        <label id="elh_perizinan_hki_tanggal_submit" for="x_tanggal_submit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_submit->caption() ?><?= $Page->tanggal_submit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el_perizinan_hki_tanggal_submit">
<input type="<?= $Page->tanggal_submit->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_tanggal_submit" name="x_tanggal_submit" id="x_tanggal_submit" placeholder="<?= HtmlEncode($Page->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Page->tanggal_submit->EditValue ?>"<?= $Page->tanggal_submit->editAttributes() ?> aria-describedby="x_tanggal_submit_help">
<?= $Page->tanggal_submit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_submit->ReadOnly && !$Page->tanggal_submit->Disabled && !isset($Page->tanggal_submit->EditAttrs["readonly"]) && !isset($Page->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fperizinan_hkiedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fperizinan_hkiedit", "x_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <div id="r_ktp" class="form-group row">
        <label id="elh_perizinan_hki_ktp" for="x_ktp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ktp->caption() ?><?= $Page->ktp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ktp->cellAttributes() ?>>
<span id="el_perizinan_hki_ktp">
<input type="<?= $Page->ktp->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_ktp" name="x_ktp" id="x_ktp" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ktp->getPlaceHolder()) ?>" value="<?= $Page->ktp->EditValue ?>"<?= $Page->ktp->editAttributes() ?> aria-describedby="x_ktp_help">
<?= $Page->ktp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ktp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <div id="r_npwp" class="form-group row">
        <label id="elh_perizinan_hki_npwp" for="x_npwp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->npwp->caption() ?><?= $Page->npwp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->npwp->cellAttributes() ?>>
<span id="el_perizinan_hki_npwp">
<input type="<?= $Page->npwp->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->npwp->getPlaceHolder()) ?>" value="<?= $Page->npwp->EditValue ?>"<?= $Page->npwp->editAttributes() ?> aria-describedby="x_npwp_help">
<?= $Page->npwp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->npwp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
    <div id="r_nib" class="form-group row">
        <label id="elh_perizinan_hki_nib" for="x_nib" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nib->caption() ?><?= $Page->nib->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nib->cellAttributes() ?>>
<span id="el_perizinan_hki_nib">
<input type="<?= $Page->nib->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_nib" name="x_nib" id="x_nib" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nib->getPlaceHolder()) ?>" value="<?= $Page->nib->EditValue ?>"<?= $Page->nib->editAttributes() ?> aria-describedby="x_nib_help">
<?= $Page->nib->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nib->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
    <div id="r_akta_pendirian" class="form-group row">
        <label id="elh_perizinan_hki_akta_pendirian" for="x_akta_pendirian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akta_pendirian->caption() ?><?= $Page->akta_pendirian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->akta_pendirian->cellAttributes() ?>>
<span id="el_perizinan_hki_akta_pendirian">
<input type="<?= $Page->akta_pendirian->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_akta_pendirian" name="x_akta_pendirian" id="x_akta_pendirian" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->akta_pendirian->getPlaceHolder()) ?>" value="<?= $Page->akta_pendirian->EditValue ?>"<?= $Page->akta_pendirian->editAttributes() ?> aria-describedby="x_akta_pendirian_help">
<?= $Page->akta_pendirian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akta_pendirian->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->surat_umk->Visible) { // surat_umk ?>
    <div id="r_surat_umk" class="form-group row">
        <label id="elh_perizinan_hki_surat_umk" for="x_surat_umk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->surat_umk->caption() ?><?= $Page->surat_umk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->surat_umk->cellAttributes() ?>>
<span id="el_perizinan_hki_surat_umk">
<input type="<?= $Page->surat_umk->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_surat_umk" name="x_surat_umk" id="x_surat_umk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->surat_umk->getPlaceHolder()) ?>" value="<?= $Page->surat_umk->EditValue ?>"<?= $Page->surat_umk->editAttributes() ?> aria-describedby="x_surat_umk_help">
<?= $Page->surat_umk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->surat_umk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
    <div id="r_ttd_pemohon" class="form-group row">
        <label id="elh_perizinan_hki_ttd_pemohon" for="x_ttd_pemohon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ttd_pemohon->caption() ?><?= $Page->ttd_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ttd_pemohon->cellAttributes() ?>>
<span id="el_perizinan_hki_ttd_pemohon">
<input type="<?= $Page->ttd_pemohon->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_ttd_pemohon" name="x_ttd_pemohon" id="x_ttd_pemohon" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ttd_pemohon->getPlaceHolder()) ?>" value="<?= $Page->ttd_pemohon->EditValue ?>"<?= $Page->ttd_pemohon->editAttributes() ?> aria-describedby="x_ttd_pemohon_help">
<?= $Page->ttd_pemohon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ttd_pemohon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_merk->Visible) { // nama_merk ?>
    <div id="r_nama_merk" class="form-group row">
        <label id="elh_perizinan_hki_nama_merk" for="x_nama_merk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_merk->caption() ?><?= $Page->nama_merk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_merk->cellAttributes() ?>>
<span id="el_perizinan_hki_nama_merk">
<input type="<?= $Page->nama_merk->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_nama_merk" name="x_nama_merk" id="x_nama_merk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_merk->getPlaceHolder()) ?>" value="<?= $Page->nama_merk->EditValue ?>"<?= $Page->nama_merk->editAttributes() ?> aria-describedby="x_nama_merk_help">
<?= $Page->nama_merk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_merk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_merk->Visible) { // label_merk ?>
    <div id="r_label_merk" class="form-group row">
        <label id="elh_perizinan_hki_label_merk" for="x_label_merk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label_merk->caption() ?><?= $Page->label_merk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_merk->cellAttributes() ?>>
<span id="el_perizinan_hki_label_merk">
<input type="<?= $Page->label_merk->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_label_merk" name="x_label_merk" id="x_label_merk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->label_merk->getPlaceHolder()) ?>" value="<?= $Page->label_merk->EditValue ?>"<?= $Page->label_merk->editAttributes() ?> aria-describedby="x_label_merk_help">
<?= $Page->label_merk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_merk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_deskripsi->Visible) { // label_deskripsi ?>
    <div id="r_label_deskripsi" class="form-group row">
        <label id="elh_perizinan_hki_label_deskripsi" for="x_label_deskripsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label_deskripsi->caption() ?><?= $Page->label_deskripsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_deskripsi->cellAttributes() ?>>
<span id="el_perizinan_hki_label_deskripsi">
<textarea data-table="perizinan_hki" data-field="x_label_deskripsi" name="x_label_deskripsi" id="x_label_deskripsi" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->label_deskripsi->getPlaceHolder()) ?>"<?= $Page->label_deskripsi->editAttributes() ?> aria-describedby="x_label_deskripsi_help"><?= $Page->label_deskripsi->EditValue ?></textarea>
<?= $Page->label_deskripsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_deskripsi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unsur_warna->Visible) { // unsur_warna ?>
    <div id="r_unsur_warna" class="form-group row">
        <label id="elh_perizinan_hki_unsur_warna" for="x_unsur_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unsur_warna->caption() ?><?= $Page->unsur_warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unsur_warna->cellAttributes() ?>>
<span id="el_perizinan_hki_unsur_warna">
<textarea data-table="perizinan_hki" data-field="x_unsur_warna" name="x_unsur_warna" id="x_unsur_warna" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->unsur_warna->getPlaceHolder()) ?>"<?= $Page->unsur_warna->editAttributes() ?> aria-describedby="x_unsur_warna_help"><?= $Page->unsur_warna->EditValue ?></textarea>
<?= $Page->unsur_warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unsur_warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_perizinan_hki_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_perizinan_hki_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="perizinan_hki" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fperizinan_hkiedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fperizinan_hkiedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
