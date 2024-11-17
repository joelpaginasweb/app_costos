

document.addEventListener("DOMContentLoaded", function() {
  let tablaBase = document.querySelector("#tabla_base");
  let dataTable = new simpleDatatables.DataTable(tablaBase, {
      perPage: 15,
      perPageSelect: [10, 15, 50]
  });

  let tablaBaseC = document.querySelector("#tabla_cliente");
  let dataTableC = new simpleDatatables.DataTable(tablaBaseC, {
      perPage: 5,
      perPageSelect: [5, 10, 20]
  });
});