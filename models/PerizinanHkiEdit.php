<?php

namespace PHPMaker2021\Dermatekno;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PerizinanHkiEdit extends PerizinanHki
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'perizinan_hki';

    // Page object name
    public $PageObjName = "PerizinanHkiEdit";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (perizinan_hki)
        if (!isset($GLOBALS["perizinan_hki"]) || get_class($GLOBALS["perizinan_hki"]) == PROJECT_NAMESPACE . "perizinan_hki") {
            $GLOBALS["perizinan_hki"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'perizinan_hki');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("perizinan_hki"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "PerizinanHkiView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->no_order->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->tanggal_terima->setVisibility();
        $this->tanggal_submit->setVisibility();
        $this->ktp->setVisibility();
        $this->npwp->setVisibility();
        $this->nib->setVisibility();
        $this->akta_pendirian->setVisibility();
        $this->surat_umk->setVisibility();
        $this->ttd_pemohon->setVisibility();
        $this->nama_merk->setVisibility();
        $this->label_merk->setVisibility();
        $this->label_deskripsi->setVisibility();
        $this->unsur_warna->setVisibility();
        $this->created_at->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PerizinanHkiList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PerizinanHkiList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'no_order' first before field var 'x_no_order'
        $val = $CurrentForm->hasValue("no_order") ? $CurrentForm->getValue("no_order") : $CurrentForm->getValue("x_no_order");
        if (!$this->no_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_order->Visible = false; // Disable update for API request
            } else {
                $this->no_order->setFormValue($val);
            }
        }

        // Check field name 'idpegawai' first before field var 'x_idpegawai'
        $val = $CurrentForm->hasValue("idpegawai") ? $CurrentForm->getValue("idpegawai") : $CurrentForm->getValue("x_idpegawai");
        if (!$this->idpegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idpegawai->Visible = false; // Disable update for API request
            } else {
                $this->idpegawai->setFormValue($val);
            }
        }

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }

        // Check field name 'tanggal_terima' first before field var 'x_tanggal_terima'
        $val = $CurrentForm->hasValue("tanggal_terima") ? $CurrentForm->getValue("tanggal_terima") : $CurrentForm->getValue("x_tanggal_terima");
        if (!$this->tanggal_terima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_terima->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_terima->setFormValue($val);
            }
            $this->tanggal_terima->CurrentValue = UnFormatDateTime($this->tanggal_terima->CurrentValue, 0);
        }

        // Check field name 'tanggal_submit' first before field var 'x_tanggal_submit'
        $val = $CurrentForm->hasValue("tanggal_submit") ? $CurrentForm->getValue("tanggal_submit") : $CurrentForm->getValue("x_tanggal_submit");
        if (!$this->tanggal_submit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_submit->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_submit->setFormValue($val);
            }
            $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
        }

        // Check field name 'ktp' first before field var 'x_ktp'
        $val = $CurrentForm->hasValue("ktp") ? $CurrentForm->getValue("ktp") : $CurrentForm->getValue("x_ktp");
        if (!$this->ktp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ktp->Visible = false; // Disable update for API request
            } else {
                $this->ktp->setFormValue($val);
            }
        }

        // Check field name 'npwp' first before field var 'x_npwp'
        $val = $CurrentForm->hasValue("npwp") ? $CurrentForm->getValue("npwp") : $CurrentForm->getValue("x_npwp");
        if (!$this->npwp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->npwp->Visible = false; // Disable update for API request
            } else {
                $this->npwp->setFormValue($val);
            }
        }

        // Check field name 'nib' first before field var 'x_nib'
        $val = $CurrentForm->hasValue("nib") ? $CurrentForm->getValue("nib") : $CurrentForm->getValue("x_nib");
        if (!$this->nib->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nib->Visible = false; // Disable update for API request
            } else {
                $this->nib->setFormValue($val);
            }
        }

        // Check field name 'akta_pendirian' first before field var 'x_akta_pendirian'
        $val = $CurrentForm->hasValue("akta_pendirian") ? $CurrentForm->getValue("akta_pendirian") : $CurrentForm->getValue("x_akta_pendirian");
        if (!$this->akta_pendirian->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->akta_pendirian->Visible = false; // Disable update for API request
            } else {
                $this->akta_pendirian->setFormValue($val);
            }
        }

        // Check field name 'surat_umk' first before field var 'x_surat_umk'
        $val = $CurrentForm->hasValue("surat_umk") ? $CurrentForm->getValue("surat_umk") : $CurrentForm->getValue("x_surat_umk");
        if (!$this->surat_umk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->surat_umk->Visible = false; // Disable update for API request
            } else {
                $this->surat_umk->setFormValue($val);
            }
        }

        // Check field name 'ttd_pemohon' first before field var 'x_ttd_pemohon'
        $val = $CurrentForm->hasValue("ttd_pemohon") ? $CurrentForm->getValue("ttd_pemohon") : $CurrentForm->getValue("x_ttd_pemohon");
        if (!$this->ttd_pemohon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ttd_pemohon->Visible = false; // Disable update for API request
            } else {
                $this->ttd_pemohon->setFormValue($val);
            }
        }

        // Check field name 'nama_merk' first before field var 'x_nama_merk'
        $val = $CurrentForm->hasValue("nama_merk") ? $CurrentForm->getValue("nama_merk") : $CurrentForm->getValue("x_nama_merk");
        if (!$this->nama_merk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_merk->Visible = false; // Disable update for API request
            } else {
                $this->nama_merk->setFormValue($val);
            }
        }

        // Check field name 'label_merk' first before field var 'x_label_merk'
        $val = $CurrentForm->hasValue("label_merk") ? $CurrentForm->getValue("label_merk") : $CurrentForm->getValue("x_label_merk");
        if (!$this->label_merk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_merk->Visible = false; // Disable update for API request
            } else {
                $this->label_merk->setFormValue($val);
            }
        }

        // Check field name 'label_deskripsi' first before field var 'x_label_deskripsi'
        $val = $CurrentForm->hasValue("label_deskripsi") ? $CurrentForm->getValue("label_deskripsi") : $CurrentForm->getValue("x_label_deskripsi");
        if (!$this->label_deskripsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_deskripsi->Visible = false; // Disable update for API request
            } else {
                $this->label_deskripsi->setFormValue($val);
            }
        }

        // Check field name 'unsur_warna' first before field var 'x_unsur_warna'
        $val = $CurrentForm->hasValue("unsur_warna") ? $CurrentForm->getValue("unsur_warna") : $CurrentForm->getValue("x_unsur_warna");
        if (!$this->unsur_warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unsur_warna->Visible = false; // Disable update for API request
            } else {
                $this->unsur_warna->setFormValue($val);
            }
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->no_order->CurrentValue = $this->no_order->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->tanggal_terima->CurrentValue = $this->tanggal_terima->FormValue;
        $this->tanggal_terima->CurrentValue = UnFormatDateTime($this->tanggal_terima->CurrentValue, 0);
        $this->tanggal_submit->CurrentValue = $this->tanggal_submit->FormValue;
        $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
        $this->ktp->CurrentValue = $this->ktp->FormValue;
        $this->npwp->CurrentValue = $this->npwp->FormValue;
        $this->nib->CurrentValue = $this->nib->FormValue;
        $this->akta_pendirian->CurrentValue = $this->akta_pendirian->FormValue;
        $this->surat_umk->CurrentValue = $this->surat_umk->FormValue;
        $this->ttd_pemohon->CurrentValue = $this->ttd_pemohon->FormValue;
        $this->nama_merk->CurrentValue = $this->nama_merk->FormValue;
        $this->label_merk->CurrentValue = $this->label_merk->FormValue;
        $this->label_deskripsi->CurrentValue = $this->label_deskripsi->FormValue;
        $this->unsur_warna->CurrentValue = $this->unsur_warna->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->no_order->setDbValue($row['no_order']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->tanggal_terima->setDbValue($row['tanggal_terima']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->ktp->setDbValue($row['ktp']);
        $this->npwp->setDbValue($row['npwp']);
        $this->nib->setDbValue($row['nib']);
        $this->akta_pendirian->setDbValue($row['akta_pendirian']);
        $this->surat_umk->setDbValue($row['surat_umk']);
        $this->ttd_pemohon->setDbValue($row['ttd_pemohon']);
        $this->nama_merk->setDbValue($row['nama_merk']);
        $this->label_merk->setDbValue($row['label_merk']);
        $this->label_deskripsi->setDbValue($row['label_deskripsi']);
        $this->unsur_warna->setDbValue($row['unsur_warna']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['no_order'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['tanggal_terima'] = null;
        $row['tanggal_submit'] = null;
        $row['ktp'] = null;
        $row['npwp'] = null;
        $row['nib'] = null;
        $row['akta_pendirian'] = null;
        $row['surat_umk'] = null;
        $row['ttd_pemohon'] = null;
        $row['nama_merk'] = null;
        $row['label_merk'] = null;
        $row['label_deskripsi'] = null;
        $row['unsur_warna'] = null;
        $row['created_at'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // no_order

        // idpegawai

        // idcustomer

        // tanggal_terima

        // tanggal_submit

        // ktp

        // npwp

        // nib

        // akta_pendirian

        // surat_umk

        // ttd_pemohon

        // nama_merk

        // label_merk

        // label_deskripsi

        // unsur_warna

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // no_order
            $this->no_order->ViewValue = $this->no_order->CurrentValue;
            $this->no_order->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
            $this->idpegawai->ViewValue = FormatNumber($this->idpegawai->ViewValue, 0, -2, -2, -2);
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
            $this->idcustomer->ViewValue = FormatNumber($this->idcustomer->ViewValue, 0, -2, -2, -2);
            $this->idcustomer->ViewCustomAttributes = "";

            // tanggal_terima
            $this->tanggal_terima->ViewValue = $this->tanggal_terima->CurrentValue;
            $this->tanggal_terima->ViewValue = FormatDateTime($this->tanggal_terima->ViewValue, 0);
            $this->tanggal_terima->ViewCustomAttributes = "";

            // tanggal_submit
            $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
            $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
            $this->tanggal_submit->ViewCustomAttributes = "";

            // ktp
            $this->ktp->ViewValue = $this->ktp->CurrentValue;
            $this->ktp->ViewCustomAttributes = "";

            // npwp
            $this->npwp->ViewValue = $this->npwp->CurrentValue;
            $this->npwp->ViewCustomAttributes = "";

            // nib
            $this->nib->ViewValue = $this->nib->CurrentValue;
            $this->nib->ViewCustomAttributes = "";

            // akta_pendirian
            $this->akta_pendirian->ViewValue = $this->akta_pendirian->CurrentValue;
            $this->akta_pendirian->ViewCustomAttributes = "";

            // surat_umk
            $this->surat_umk->ViewValue = $this->surat_umk->CurrentValue;
            $this->surat_umk->ViewCustomAttributes = "";

            // ttd_pemohon
            $this->ttd_pemohon->ViewValue = $this->ttd_pemohon->CurrentValue;
            $this->ttd_pemohon->ViewCustomAttributes = "";

            // nama_merk
            $this->nama_merk->ViewValue = $this->nama_merk->CurrentValue;
            $this->nama_merk->ViewCustomAttributes = "";

            // label_merk
            $this->label_merk->ViewValue = $this->label_merk->CurrentValue;
            $this->label_merk->ViewCustomAttributes = "";

            // label_deskripsi
            $this->label_deskripsi->ViewValue = $this->label_deskripsi->CurrentValue;
            $this->label_deskripsi->ViewCustomAttributes = "";

            // unsur_warna
            $this->unsur_warna->ViewValue = $this->unsur_warna->CurrentValue;
            $this->unsur_warna->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // no_order
            $this->no_order->LinkCustomAttributes = "";
            $this->no_order->HrefValue = "";
            $this->no_order->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // tanggal_terima
            $this->tanggal_terima->LinkCustomAttributes = "";
            $this->tanggal_terima->HrefValue = "";
            $this->tanggal_terima->TooltipValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";
            $this->tanggal_submit->TooltipValue = "";

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";
            $this->ktp->TooltipValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";
            $this->npwp->TooltipValue = "";

            // nib
            $this->nib->LinkCustomAttributes = "";
            $this->nib->HrefValue = "";
            $this->nib->TooltipValue = "";

            // akta_pendirian
            $this->akta_pendirian->LinkCustomAttributes = "";
            $this->akta_pendirian->HrefValue = "";
            $this->akta_pendirian->TooltipValue = "";

            // surat_umk
            $this->surat_umk->LinkCustomAttributes = "";
            $this->surat_umk->HrefValue = "";
            $this->surat_umk->TooltipValue = "";

            // ttd_pemohon
            $this->ttd_pemohon->LinkCustomAttributes = "";
            $this->ttd_pemohon->HrefValue = "";
            $this->ttd_pemohon->TooltipValue = "";

            // nama_merk
            $this->nama_merk->LinkCustomAttributes = "";
            $this->nama_merk->HrefValue = "";
            $this->nama_merk->TooltipValue = "";

            // label_merk
            $this->label_merk->LinkCustomAttributes = "";
            $this->label_merk->HrefValue = "";
            $this->label_merk->TooltipValue = "";

            // label_deskripsi
            $this->label_deskripsi->LinkCustomAttributes = "";
            $this->label_deskripsi->HrefValue = "";
            $this->label_deskripsi->TooltipValue = "";

            // unsur_warna
            $this->unsur_warna->LinkCustomAttributes = "";
            $this->unsur_warna->HrefValue = "";
            $this->unsur_warna->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // no_order
            $this->no_order->EditAttrs["class"] = "form-control";
            $this->no_order->EditCustomAttributes = "";
            if (!$this->no_order->Raw) {
                $this->no_order->CurrentValue = HtmlDecode($this->no_order->CurrentValue);
            }
            $this->no_order->EditValue = HtmlEncode($this->no_order->CurrentValue);
            $this->no_order->PlaceHolder = RemoveHtml($this->no_order->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $this->idpegawai->EditValue = HtmlEncode($this->idpegawai->CurrentValue);
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $this->idcustomer->EditValue = HtmlEncode($this->idcustomer->CurrentValue);
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // tanggal_terima
            $this->tanggal_terima->EditAttrs["class"] = "form-control";
            $this->tanggal_terima->EditCustomAttributes = "";
            $this->tanggal_terima->EditValue = HtmlEncode(FormatDateTime($this->tanggal_terima->CurrentValue, 8));
            $this->tanggal_terima->PlaceHolder = RemoveHtml($this->tanggal_terima->caption());

            // tanggal_submit
            $this->tanggal_submit->EditAttrs["class"] = "form-control";
            $this->tanggal_submit->EditCustomAttributes = "";
            $this->tanggal_submit->EditValue = HtmlEncode(FormatDateTime($this->tanggal_submit->CurrentValue, 8));
            $this->tanggal_submit->PlaceHolder = RemoveHtml($this->tanggal_submit->caption());

            // ktp
            $this->ktp->EditAttrs["class"] = "form-control";
            $this->ktp->EditCustomAttributes = "";
            if (!$this->ktp->Raw) {
                $this->ktp->CurrentValue = HtmlDecode($this->ktp->CurrentValue);
            }
            $this->ktp->EditValue = HtmlEncode($this->ktp->CurrentValue);
            $this->ktp->PlaceHolder = RemoveHtml($this->ktp->caption());

            // npwp
            $this->npwp->EditAttrs["class"] = "form-control";
            $this->npwp->EditCustomAttributes = "";
            if (!$this->npwp->Raw) {
                $this->npwp->CurrentValue = HtmlDecode($this->npwp->CurrentValue);
            }
            $this->npwp->EditValue = HtmlEncode($this->npwp->CurrentValue);
            $this->npwp->PlaceHolder = RemoveHtml($this->npwp->caption());

            // nib
            $this->nib->EditAttrs["class"] = "form-control";
            $this->nib->EditCustomAttributes = "";
            if (!$this->nib->Raw) {
                $this->nib->CurrentValue = HtmlDecode($this->nib->CurrentValue);
            }
            $this->nib->EditValue = HtmlEncode($this->nib->CurrentValue);
            $this->nib->PlaceHolder = RemoveHtml($this->nib->caption());

            // akta_pendirian
            $this->akta_pendirian->EditAttrs["class"] = "form-control";
            $this->akta_pendirian->EditCustomAttributes = "";
            if (!$this->akta_pendirian->Raw) {
                $this->akta_pendirian->CurrentValue = HtmlDecode($this->akta_pendirian->CurrentValue);
            }
            $this->akta_pendirian->EditValue = HtmlEncode($this->akta_pendirian->CurrentValue);
            $this->akta_pendirian->PlaceHolder = RemoveHtml($this->akta_pendirian->caption());

            // surat_umk
            $this->surat_umk->EditAttrs["class"] = "form-control";
            $this->surat_umk->EditCustomAttributes = "";
            if (!$this->surat_umk->Raw) {
                $this->surat_umk->CurrentValue = HtmlDecode($this->surat_umk->CurrentValue);
            }
            $this->surat_umk->EditValue = HtmlEncode($this->surat_umk->CurrentValue);
            $this->surat_umk->PlaceHolder = RemoveHtml($this->surat_umk->caption());

            // ttd_pemohon
            $this->ttd_pemohon->EditAttrs["class"] = "form-control";
            $this->ttd_pemohon->EditCustomAttributes = "";
            if (!$this->ttd_pemohon->Raw) {
                $this->ttd_pemohon->CurrentValue = HtmlDecode($this->ttd_pemohon->CurrentValue);
            }
            $this->ttd_pemohon->EditValue = HtmlEncode($this->ttd_pemohon->CurrentValue);
            $this->ttd_pemohon->PlaceHolder = RemoveHtml($this->ttd_pemohon->caption());

            // nama_merk
            $this->nama_merk->EditAttrs["class"] = "form-control";
            $this->nama_merk->EditCustomAttributes = "";
            if (!$this->nama_merk->Raw) {
                $this->nama_merk->CurrentValue = HtmlDecode($this->nama_merk->CurrentValue);
            }
            $this->nama_merk->EditValue = HtmlEncode($this->nama_merk->CurrentValue);
            $this->nama_merk->PlaceHolder = RemoveHtml($this->nama_merk->caption());

            // label_merk
            $this->label_merk->EditAttrs["class"] = "form-control";
            $this->label_merk->EditCustomAttributes = "";
            if (!$this->label_merk->Raw) {
                $this->label_merk->CurrentValue = HtmlDecode($this->label_merk->CurrentValue);
            }
            $this->label_merk->EditValue = HtmlEncode($this->label_merk->CurrentValue);
            $this->label_merk->PlaceHolder = RemoveHtml($this->label_merk->caption());

            // label_deskripsi
            $this->label_deskripsi->EditAttrs["class"] = "form-control";
            $this->label_deskripsi->EditCustomAttributes = "";
            $this->label_deskripsi->EditValue = HtmlEncode($this->label_deskripsi->CurrentValue);
            $this->label_deskripsi->PlaceHolder = RemoveHtml($this->label_deskripsi->caption());

            // unsur_warna
            $this->unsur_warna->EditAttrs["class"] = "form-control";
            $this->unsur_warna->EditCustomAttributes = "";
            $this->unsur_warna->EditValue = HtmlEncode($this->unsur_warna->CurrentValue);
            $this->unsur_warna->PlaceHolder = RemoveHtml($this->unsur_warna->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // no_order
            $this->no_order->LinkCustomAttributes = "";
            $this->no_order->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // tanggal_terima
            $this->tanggal_terima->LinkCustomAttributes = "";
            $this->tanggal_terima->HrefValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";

            // nib
            $this->nib->LinkCustomAttributes = "";
            $this->nib->HrefValue = "";

            // akta_pendirian
            $this->akta_pendirian->LinkCustomAttributes = "";
            $this->akta_pendirian->HrefValue = "";

            // surat_umk
            $this->surat_umk->LinkCustomAttributes = "";
            $this->surat_umk->HrefValue = "";

            // ttd_pemohon
            $this->ttd_pemohon->LinkCustomAttributes = "";
            $this->ttd_pemohon->HrefValue = "";

            // nama_merk
            $this->nama_merk->LinkCustomAttributes = "";
            $this->nama_merk->HrefValue = "";

            // label_merk
            $this->label_merk->LinkCustomAttributes = "";
            $this->label_merk->HrefValue = "";

            // label_deskripsi
            $this->label_deskripsi->LinkCustomAttributes = "";
            $this->label_deskripsi->HrefValue = "";

            // unsur_warna
            $this->unsur_warna->LinkCustomAttributes = "";
            $this->unsur_warna->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->no_order->Required) {
            if (!$this->no_order->IsDetailKey && EmptyValue($this->no_order->FormValue)) {
                $this->no_order->addErrorMessage(str_replace("%s", $this->no_order->caption(), $this->no_order->RequiredErrorMessage));
            }
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idpegawai->FormValue)) {
            $this->idpegawai->addErrorMessage($this->idpegawai->getErrorMessage(false));
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idcustomer->FormValue)) {
            $this->idcustomer->addErrorMessage($this->idcustomer->getErrorMessage(false));
        }
        if ($this->tanggal_terima->Required) {
            if (!$this->tanggal_terima->IsDetailKey && EmptyValue($this->tanggal_terima->FormValue)) {
                $this->tanggal_terima->addErrorMessage(str_replace("%s", $this->tanggal_terima->caption(), $this->tanggal_terima->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_terima->FormValue)) {
            $this->tanggal_terima->addErrorMessage($this->tanggal_terima->getErrorMessage(false));
        }
        if ($this->tanggal_submit->Required) {
            if (!$this->tanggal_submit->IsDetailKey && EmptyValue($this->tanggal_submit->FormValue)) {
                $this->tanggal_submit->addErrorMessage(str_replace("%s", $this->tanggal_submit->caption(), $this->tanggal_submit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_submit->FormValue)) {
            $this->tanggal_submit->addErrorMessage($this->tanggal_submit->getErrorMessage(false));
        }
        if ($this->ktp->Required) {
            if (!$this->ktp->IsDetailKey && EmptyValue($this->ktp->FormValue)) {
                $this->ktp->addErrorMessage(str_replace("%s", $this->ktp->caption(), $this->ktp->RequiredErrorMessage));
            }
        }
        if ($this->npwp->Required) {
            if (!$this->npwp->IsDetailKey && EmptyValue($this->npwp->FormValue)) {
                $this->npwp->addErrorMessage(str_replace("%s", $this->npwp->caption(), $this->npwp->RequiredErrorMessage));
            }
        }
        if ($this->nib->Required) {
            if (!$this->nib->IsDetailKey && EmptyValue($this->nib->FormValue)) {
                $this->nib->addErrorMessage(str_replace("%s", $this->nib->caption(), $this->nib->RequiredErrorMessage));
            }
        }
        if ($this->akta_pendirian->Required) {
            if (!$this->akta_pendirian->IsDetailKey && EmptyValue($this->akta_pendirian->FormValue)) {
                $this->akta_pendirian->addErrorMessage(str_replace("%s", $this->akta_pendirian->caption(), $this->akta_pendirian->RequiredErrorMessage));
            }
        }
        if ($this->surat_umk->Required) {
            if (!$this->surat_umk->IsDetailKey && EmptyValue($this->surat_umk->FormValue)) {
                $this->surat_umk->addErrorMessage(str_replace("%s", $this->surat_umk->caption(), $this->surat_umk->RequiredErrorMessage));
            }
        }
        if ($this->ttd_pemohon->Required) {
            if (!$this->ttd_pemohon->IsDetailKey && EmptyValue($this->ttd_pemohon->FormValue)) {
                $this->ttd_pemohon->addErrorMessage(str_replace("%s", $this->ttd_pemohon->caption(), $this->ttd_pemohon->RequiredErrorMessage));
            }
        }
        if ($this->nama_merk->Required) {
            if (!$this->nama_merk->IsDetailKey && EmptyValue($this->nama_merk->FormValue)) {
                $this->nama_merk->addErrorMessage(str_replace("%s", $this->nama_merk->caption(), $this->nama_merk->RequiredErrorMessage));
            }
        }
        if ($this->label_merk->Required) {
            if (!$this->label_merk->IsDetailKey && EmptyValue($this->label_merk->FormValue)) {
                $this->label_merk->addErrorMessage(str_replace("%s", $this->label_merk->caption(), $this->label_merk->RequiredErrorMessage));
            }
        }
        if ($this->label_deskripsi->Required) {
            if (!$this->label_deskripsi->IsDetailKey && EmptyValue($this->label_deskripsi->FormValue)) {
                $this->label_deskripsi->addErrorMessage(str_replace("%s", $this->label_deskripsi->caption(), $this->label_deskripsi->RequiredErrorMessage));
            }
        }
        if ($this->unsur_warna->Required) {
            if (!$this->unsur_warna->IsDetailKey && EmptyValue($this->unsur_warna->FormValue)) {
                $this->unsur_warna->addErrorMessage(str_replace("%s", $this->unsur_warna->caption(), $this->unsur_warna->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // no_order
            $this->no_order->setDbValueDef($rsnew, $this->no_order->CurrentValue, null, $this->no_order->ReadOnly);

            // idpegawai
            $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, null, $this->idpegawai->ReadOnly);

            // idcustomer
            $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, null, $this->idcustomer->ReadOnly);

            // tanggal_terima
            $this->tanggal_terima->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_terima->CurrentValue, 0), null, $this->tanggal_terima->ReadOnly);

            // tanggal_submit
            $this->tanggal_submit->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_submit->CurrentValue, 0), null, $this->tanggal_submit->ReadOnly);

            // ktp
            $this->ktp->setDbValueDef($rsnew, $this->ktp->CurrentValue, null, $this->ktp->ReadOnly);

            // npwp
            $this->npwp->setDbValueDef($rsnew, $this->npwp->CurrentValue, null, $this->npwp->ReadOnly);

            // nib
            $this->nib->setDbValueDef($rsnew, $this->nib->CurrentValue, null, $this->nib->ReadOnly);

            // akta_pendirian
            $this->akta_pendirian->setDbValueDef($rsnew, $this->akta_pendirian->CurrentValue, null, $this->akta_pendirian->ReadOnly);

            // surat_umk
            $this->surat_umk->setDbValueDef($rsnew, $this->surat_umk->CurrentValue, null, $this->surat_umk->ReadOnly);

            // ttd_pemohon
            $this->ttd_pemohon->setDbValueDef($rsnew, $this->ttd_pemohon->CurrentValue, null, $this->ttd_pemohon->ReadOnly);

            // nama_merk
            $this->nama_merk->setDbValueDef($rsnew, $this->nama_merk->CurrentValue, null, $this->nama_merk->ReadOnly);

            // label_merk
            $this->label_merk->setDbValueDef($rsnew, $this->label_merk->CurrentValue, null, $this->label_merk->ReadOnly);

            // label_deskripsi
            $this->label_deskripsi->setDbValueDef($rsnew, $this->label_deskripsi->CurrentValue, null, $this->label_deskripsi->ReadOnly);

            // unsur_warna
            $this->unsur_warna->setDbValueDef($rsnew, $this->unsur_warna->CurrentValue, null, $this->unsur_warna->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, $this->created_at->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PerizinanHkiList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
