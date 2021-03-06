<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpdedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpdedit = currentForm = new ew.Form("fnpdedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd)
        ew.vars.tables.npd = currentTable;
    fnpdedit.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["idkategoribarang", [fields.idkategoribarang.visible && fields.idkategoribarang.required ? ew.Validators.required(fields.idkategoribarang.caption) : null], fields.idkategoribarang.isInvalid],
        ["idjenisbarang", [fields.idjenisbarang.visible && fields.idjenisbarang.required ? ew.Validators.required(fields.idjenisbarang.caption) : null], fields.idjenisbarang.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null], fields.idproduct_acuan.isInvalid],
        ["idkualitasbarang", [fields.idkualitasbarang.visible && fields.idkualitasbarang.required ? ew.Validators.required(fields.idkualitasbarang.caption) : null], fields.idkualitasbarang.isInvalid],
        ["idkemasanbarang", [fields.idkemasanbarang.visible && fields.idkemasanbarang.required ? ew.Validators.required(fields.idkemasanbarang.caption) : null], fields.idkemasanbarang.isInvalid],
        ["label", [fields.label.visible && fields.label.required ? ew.Validators.required(fields.label.caption) : null], fields.label.isInvalid],
        ["bahan", [fields.bahan.visible && fields.bahan.required ? ew.Validators.required(fields.bahan.caption) : null], fields.bahan.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["tambahan", [fields.tambahan.visible && fields.tambahan.required ? ew.Validators.required(fields.tambahan.caption) : null], fields.tambahan.isInvalid],
        ["orderperdana", [fields.orderperdana.visible && fields.orderperdana.required ? ew.Validators.required(fields.orderperdana.caption) : null, ew.Validators.integer], fields.orderperdana.isInvalid],
        ["orderreguler", [fields.orderreguler.visible && fields.orderreguler.required ? ew.Validators.required(fields.orderreguler.caption) : null, ew.Validators.integer], fields.orderreguler.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpdedit,
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
    fnpdedit.validate = function () {
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
    fnpdedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpdedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpdedit.lists.idkategoribarang = <?= $Page->idkategoribarang->toClientList($Page) ?>;
    fnpdedit.lists.idjenisbarang = <?= $Page->idjenisbarang->toClientList($Page) ?>;
    fnpdedit.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    fnpdedit.lists.idkualitasbarang = <?= $Page->idkualitasbarang->toClientList($Page) ?>;
    fnpdedit.lists.idkemasanbarang = <?= $Page->idkemasanbarang->toClientList($Page) ?>;
    loadjs.done("fnpdedit");
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
<form name="fnpdedit" id="fnpdedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <div id="r_idkategoribarang" class="form-group row">
        <label id="elh_npd_idkategoribarang" for="x_idkategoribarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkategoribarang->caption() ?><?= $Page->idkategoribarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el_npd_idkategoribarang">
<?php $Page->idkategoribarang->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkategoribarang"
        name="x_idkategoribarang"
        class="form-control ew-select<?= $Page->idkategoribarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idkategoribarang"
        data-table="npd"
        data-field="x_idkategoribarang"
        data-value-separator="<?= $Page->idkategoribarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkategoribarang->getPlaceHolder()) ?>"
        <?= $Page->idkategoribarang->editAttributes() ?>>
        <?= $Page->idkategoribarang->selectOptionListHtml("x_idkategoribarang") ?>
    </select>
    <?= $Page->idkategoribarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkategoribarang->getErrorMessage() ?></div>
<?= $Page->idkategoribarang->Lookup->getParamTag($Page, "p_x_idkategoribarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idkategoribarang']"),
        options = { name: "x_idkategoribarang", selectId: "npd_x_idkategoribarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idkategoribarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
    <div id="r_idjenisbarang" class="form-group row">
        <label id="elh_npd_idjenisbarang" for="x_idjenisbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenisbarang->caption() ?><?= $Page->idjenisbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el_npd_idjenisbarang">
    <select
        id="x_idjenisbarang"
        name="x_idjenisbarang"
        class="form-control ew-select<?= $Page->idjenisbarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idjenisbarang"
        data-table="npd"
        data-field="x_idjenisbarang"
        data-value-separator="<?= $Page->idjenisbarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idjenisbarang->getPlaceHolder()) ?>"
        <?= $Page->idjenisbarang->editAttributes() ?>>
        <?= $Page->idjenisbarang->selectOptionListHtml("x_idjenisbarang") ?>
    </select>
    <?= $Page->idjenisbarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idjenisbarang->getErrorMessage() ?></div>
<?= $Page->idjenisbarang->Lookup->getParamTag($Page, "p_x_idjenisbarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idjenisbarang']"),
        options = { name: "x_idjenisbarang", selectId: "npd_x_idjenisbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idjenisbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label id="elh_npd_idproduct_acuan" for="x_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct_acuan->caption() ?><?= $Page->idproduct_acuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_npd_idproduct_acuan">
    <select
        id="x_idproduct_acuan"
        name="x_idproduct_acuan"
        class="form-control ew-select<?= $Page->idproduct_acuan->isInvalidClass() ?>"
        data-select2-id="npd_x_idproduct_acuan"
        data-table="npd"
        data-field="x_idproduct_acuan"
        data-value-separator="<?= $Page->idproduct_acuan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idproduct_acuan->getPlaceHolder()) ?>"
        <?= $Page->idproduct_acuan->editAttributes() ?>>
        <?= $Page->idproduct_acuan->selectOptionListHtml("x_idproduct_acuan") ?>
    </select>
    <?= $Page->idproduct_acuan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idproduct_acuan->getErrorMessage() ?></div>
<?= $Page->idproduct_acuan->Lookup->getParamTag($Page, "p_x_idproduct_acuan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idproduct_acuan']"),
        options = { name: "x_idproduct_acuan", selectId: "npd_x_idproduct_acuan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idproduct_acuan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
    <div id="r_idkualitasbarang" class="form-group row">
        <label id="elh_npd_idkualitasbarang" for="x_idkualitasbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkualitasbarang->caption() ?><?= $Page->idkualitasbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkualitasbarang->cellAttributes() ?>>
<span id="el_npd_idkualitasbarang">
    <select
        id="x_idkualitasbarang"
        name="x_idkualitasbarang"
        class="form-control ew-select<?= $Page->idkualitasbarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idkualitasbarang"
        data-table="npd"
        data-field="x_idkualitasbarang"
        data-value-separator="<?= $Page->idkualitasbarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkualitasbarang->getPlaceHolder()) ?>"
        <?= $Page->idkualitasbarang->editAttributes() ?>>
        <?= $Page->idkualitasbarang->selectOptionListHtml("x_idkualitasbarang") ?>
    </select>
    <?= $Page->idkualitasbarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkualitasbarang->getErrorMessage() ?></div>
<?= $Page->idkualitasbarang->Lookup->getParamTag($Page, "p_x_idkualitasbarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idkualitasbarang']"),
        options = { name: "x_idkualitasbarang", selectId: "npd_x_idkualitasbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idkualitasbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkemasanbarang->Visible) { // idkemasanbarang ?>
    <div id="r_idkemasanbarang" class="form-group row">
        <label id="elh_npd_idkemasanbarang" for="x_idkemasanbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkemasanbarang->caption() ?><?= $Page->idkemasanbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkemasanbarang->cellAttributes() ?>>
<span id="el_npd_idkemasanbarang">
    <select
        id="x_idkemasanbarang"
        name="x_idkemasanbarang"
        class="form-control ew-select<?= $Page->idkemasanbarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idkemasanbarang"
        data-table="npd"
        data-field="x_idkemasanbarang"
        data-value-separator="<?= $Page->idkemasanbarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkemasanbarang->getPlaceHolder()) ?>"
        <?= $Page->idkemasanbarang->editAttributes() ?>>
        <?= $Page->idkemasanbarang->selectOptionListHtml("x_idkemasanbarang") ?>
    </select>
    <?= $Page->idkemasanbarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkemasanbarang->getErrorMessage() ?></div>
<?= $Page->idkemasanbarang->Lookup->getParamTag($Page, "p_x_idkemasanbarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idkemasanbarang']"),
        options = { name: "x_idkemasanbarang", selectId: "npd_x_idkemasanbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idkemasanbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <div id="r_label" class="form-group row">
        <label id="elh_npd_label" for="x_label" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label->caption() ?><?= $Page->label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label->cellAttributes() ?>>
<span id="el_npd_label">
<input type="<?= $Page->label->getInputTextType() ?>" data-table="npd" data-field="x_label" name="x_label" id="x_label" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->label->getPlaceHolder()) ?>" value="<?= $Page->label->EditValue ?>"<?= $Page->label->editAttributes() ?> aria-describedby="x_label_help">
<?= $Page->label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan->Visible) { // bahan ?>
    <div id="r_bahan" class="form-group row">
        <label id="elh_npd_bahan" for="x_bahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahan->caption() ?><?= $Page->bahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan->cellAttributes() ?>>
<span id="el_npd_bahan">
<input type="<?= $Page->bahan->getInputTextType() ?>" data-table="npd" data-field="x_bahan" name="x_bahan" id="x_bahan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahan->getPlaceHolder()) ?>" value="<?= $Page->bahan->EditValue ?>"<?= $Page->bahan->editAttributes() ?> aria-describedby="x_bahan_help">
<?= $Page->bahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label id="elh_npd_ukuran" for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran->caption() ?><?= $Page->ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_npd_ukuran">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="npd" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?> aria-describedby="x_ukuran_help">
<?= $Page->ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="npd" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_npd_parfum" for="x_parfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<span id="el_npd_parfum">
<input type="<?= $Page->parfum->getInputTextType() ?>" data-table="npd" data-field="x_parfum" name="x_parfum" id="x_parfum" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->parfum->getPlaceHolder()) ?>" value="<?= $Page->parfum->EditValue ?>"<?= $Page->parfum->editAttributes() ?> aria-describedby="x_parfum_help">
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_npd_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<span id="el_npd_harga">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="npd" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?> aria-describedby="x_harga_help">
<?= $Page->harga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <div id="r_tambahan" class="form-group row">
        <label id="elh_npd_tambahan" for="x_tambahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tambahan->caption() ?><?= $Page->tambahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tambahan->cellAttributes() ?>>
<span id="el_npd_tambahan">
<textarea data-table="npd" data-field="x_tambahan" name="x_tambahan" id="x_tambahan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tambahan->getPlaceHolder()) ?>"<?= $Page->tambahan->editAttributes() ?> aria-describedby="x_tambahan_help"><?= $Page->tambahan->EditValue ?></textarea>
<?= $Page->tambahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tambahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <div id="r_orderperdana" class="form-group row">
        <label id="elh_npd_orderperdana" for="x_orderperdana" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderperdana->caption() ?><?= $Page->orderperdana->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el_npd_orderperdana">
<input type="<?= $Page->orderperdana->getInputTextType() ?>" data-table="npd" data-field="x_orderperdana" name="x_orderperdana" id="x_orderperdana" size="30" placeholder="<?= HtmlEncode($Page->orderperdana->getPlaceHolder()) ?>" value="<?= $Page->orderperdana->EditValue ?>"<?= $Page->orderperdana->editAttributes() ?> aria-describedby="x_orderperdana_help">
<?= $Page->orderperdana->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderperdana->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderreguler->Visible) { // orderreguler ?>
    <div id="r_orderreguler" class="form-group row">
        <label id="elh_npd_orderreguler" for="x_orderreguler" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderreguler->caption() ?><?= $Page->orderreguler->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderreguler->cellAttributes() ?>>
<span id="el_npd_orderreguler">
<input type="<?= $Page->orderreguler->getInputTextType() ?>" data-table="npd" data-field="x_orderreguler" name="x_orderreguler" id="x_orderreguler" size="30" placeholder="<?= HtmlEncode($Page->orderreguler->getPlaceHolder()) ?>" value="<?= $Page->orderreguler->EditValue ?>"<?= $Page->orderreguler->editAttributes() ?> aria-describedby="x_orderreguler_help">
<?= $Page->orderreguler->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderreguler->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="npd" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("npd_status", explode(",", $Page->getCurrentDetailTable())) && $npd_status->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_status") {
            $firstActiveDetailTable = "npd_status";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_status") ?>" href="#tab_npd_status" data-toggle="tab"><?= $Language->tablePhrase("npd_status", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_sample") ?>" href="#tab_npd_sample" data-toggle="tab"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_review") ?>" href="#tab_npd_review" data-toggle="tab"><?= $Language->tablePhrase("npd_review", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" href="#tab_npd_confirm" data-toggle="tab"><?= $Language->tablePhrase("npd_confirm", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_harga") ?>" href="#tab_npd_harga" data-toggle="tab"><?= $Language->tablePhrase("npd_harga", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("npd_status", explode(",", $Page->getCurrentDetailTable())) && $npd_status->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_status") {
            $firstActiveDetailTable = "npd_status";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_status") ?>" id="tab_npd_status"><!-- page* -->
<?php include_once "NpdStatusGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_sample") ?>" id="tab_npd_sample"><!-- page* -->
<?php include_once "NpdSampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_review") ?>" id="tab_npd_review"><!-- page* -->
<?php include_once "NpdReviewGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" id="tab_npd_confirm"><!-- page* -->
<?php include_once "NpdConfirmGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_harga") ?>" id="tab_npd_harga"><!-- page* -->
<?php include_once "NpdHargaGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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
    ew.addEventHandlers("npd");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
