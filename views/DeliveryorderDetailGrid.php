<?php

namespace PHPMaker2021\Dermateknonew;

// Set up and run Grid object
$Grid = Container("DeliveryorderDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fdeliveryorder_detailgrid = new ew.Form("fdeliveryorder_detailgrid", "grid");
    fdeliveryorder_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.deliveryorder_detail)
        ew.vars.tables.deliveryorder_detail = currentTable;
    fdeliveryorder_detailgrid.addFields([
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null], fields.idorder.isInvalid],
        ["idorder_detail", [fields.idorder_detail.visible && fields.idorder_detail.required ? ew.Validators.required(fields.idorder_detail.caption) : null], fields.idorder_detail.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdeliveryorder_detailgrid,
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
    fdeliveryorder_detailgrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fdeliveryorder_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idorder_detail", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisa", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahkirim", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fdeliveryorder_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdeliveryorder_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdeliveryorder_detailgrid.lists.idorder = <?= $Grid->idorder->toClientList($Grid) ?>;
    fdeliveryorder_detailgrid.lists.idorder_detail = <?= $Grid->idorder_detail->toClientList($Grid) ?>;
    loadjs.done("fdeliveryorder_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> deliveryorder_detail">
<div id="fdeliveryorder_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_deliveryorder_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_deliveryorder_detailgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->idorder->Visible) { // idorder ?>
        <th data-name="idorder" class="<?= $Grid->idorder->headerCellClass() ?>"><div id="elh_deliveryorder_detail_idorder" class="deliveryorder_detail_idorder"><?= $Grid->renderSort($Grid->idorder) ?></div></th>
<?php } ?>
<?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <th data-name="idorder_detail" class="<?= $Grid->idorder_detail->headerCellClass() ?>"><div id="elh_deliveryorder_detail_idorder_detail" class="deliveryorder_detail_idorder_detail"><?= $Grid->renderSort($Grid->idorder_detail) ?></div></th>
<?php } ?>
<?php if ($Grid->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Grid->sisa->headerCellClass() ?>"><div id="elh_deliveryorder_detail_sisa" class="deliveryorder_detail_sisa"><?= $Grid->renderSort($Grid->sisa) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Grid->jumlahkirim->headerCellClass() ?>"><div id="elh_deliveryorder_detail_jumlahkirim" class="deliveryorder_detail_jumlahkirim"><?= $Grid->renderSort($Grid->jumlahkirim) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_deliveryorder_detail", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder" <?= $Grid->idorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder" class="form-group">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="deliveryorder_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder" class="form-group">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="deliveryorder_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<?= $Grid->idorder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder" data-hidden="1" name="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idorder" id="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder" data-hidden="1" name="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idorder" id="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail" <?= $Grid->idorder_detail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder_detail" class="form-group">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="deliveryorder_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder_detail" id="o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder_detail" class="form-group">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="deliveryorder_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_idorder_detail">
<span<?= $Grid->idorder_detail->viewAttributes() ?>>
<?= $Grid->idorder_detail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder_detail" data-hidden="1" name="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idorder_detail" id="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->FormValue) ?>">
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder_detail" data-hidden="1" name="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idorder_detail" id="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Grid->sisa->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<?= $Grid->sisa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" id="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<input type="hidden" data-table="deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" id="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Grid->jumlahkirim->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_deliveryorder_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<?= $Grid->jumlahkirim->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" id="fdeliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<input type="hidden" data-table="deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" id="fdeliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fdeliveryorder_detailgrid","load"], function () {
    fdeliveryorder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_deliveryorder_detail", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_deliveryorder_detail_idorder" class="form-group deliveryorder_detail_idorder">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="deliveryorder_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_deliveryorder_detail_idorder" class="form-group deliveryorder_detail_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder->getDisplayValue($Grid->idorder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idorder" id="x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_deliveryorder_detail_idorder_detail" class="form-group deliveryorder_detail_idorder_detail">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="deliveryorder_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "deliveryorder_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_deliveryorder_detail_idorder_detail" class="form-group deliveryorder_detail_idorder_detail">
<span<?= $Grid->idorder_detail->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder_detail->getDisplayValue($Grid->idorder_detail->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder_detail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idorder_detail" id="x<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_idorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder_detail" id="o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_deliveryorder_detail_sisa" class="form-group deliveryorder_detail_sisa">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_deliveryorder_detail_sisa" class="form-group deliveryorder_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisa->getDisplayValue($Grid->sisa->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_deliveryorder_detail_jumlahkirim" class="form-group deliveryorder_detail_jumlahkirim">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_deliveryorder_detail_jumlahkirim" class="form-group deliveryorder_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahkirim->getDisplayValue($Grid->jumlahkirim->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fdeliveryorder_detailgrid","load"], function() {
    fdeliveryorder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdeliveryorder_detailgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
