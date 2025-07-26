function initializeTables() {
    // Format tanggal untuk nama file
    const dateStr = new Date().toISOString().slice(0, 10); // contoh: 2025-07-24

    // Default table
    new DataTable("#example");

    // Scroll vertical
    new DataTable("#scroll-vertical", {
        scrollY: "210px",
        scrollCollapse: true,
        paging: false
    });

    // Scroll horizontal
    new DataTable("#scroll-horizontal", {
        scrollX: true
    });

    // Alternative pagination
    new DataTable("#alternative-pagination", {
        pagingType: "full_numbers"
    });

    // Fixed header
    new DataTable("#fixed-header", {
        fixedHeader: true
    });

    // Modal responsive datatable
    new DataTable("#model-datatables", {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        let data = row.data();
                        return "Details for " + data[0] + " " + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: "table"
                })
            }
        }
    });

    // Buttons with dynamic filename
    new DataTable("#buttons-datatables", {
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                title: "Data Export"
            },
            {
                extend: "csv",
                filename: "Laporan_CSV_" + dateStr,
                title: "Data Export"
            },
            {
                extend: "excel",
                filename: "Laporan_Excel_" + dateStr,
                title: "Data Export"
            },
            {
                extend: "print",
                title: "Data Export"
            },
            {
                extend: "pdf",
                filename: "Laporan_PDF_" + dateStr,
                title: "Data Export"
            }
        ]
    });

    // Ajax example
    new DataTable("#ajax-datatables", {
        ajax: "assets/json/datatable.json"
    });

    // Add row functionality
    const table = $("#add-rows").DataTable();
    let rowCount = 1;
    $("#addRow").on("click", function () {
        table.row.add([
            rowCount + ".1", rowCount + ".2", rowCount + ".3", rowCount + ".4",
            rowCount + ".5", rowCount + ".6", rowCount + ".7", rowCount + ".8",
            rowCount + ".9", rowCount + ".10", rowCount + ".11", rowCount + ".12"
        ]).draw(false);
        rowCount++;
    });

    // Trigger one initial row
    $("#addRow").trigger("click");
}

document.addEventListener("DOMContentLoaded", function () {
    initializeTables();
});
