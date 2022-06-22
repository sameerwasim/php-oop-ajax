const add = (e) => {
  e.preventDefault();

  $.ajax({
    type: "POST",
    url: "./action.php",
    data: $(e.target).serialize(),
    beforeSend: () => alert("Saving"),
    success: (res) => {
      fetch();

      $("#id").val("");
      $("#action").val("add");
      $("#btn").html("Add");
      $("#category").val("");
      $("#parent").val("");

      alert("Saved");
    },
  });
};

const fetch = () => {
  $.ajax({
    type: "GET",
    url: "./action.php",
    data: { action: "all" },
    success: (res) => {
      const categories = JSON.parse(res);
      optionValues(categories);
      tableValues(categories);
    },
  });
};

const optionValues = (categories) => {
  var select = document.getElementById("parent");
  $("#parent").empty();

  var opt = document.createElement("option");
  opt.value = "";
  opt.innerHTML = "--- Select ---";
  select.appendChild(opt);

  for (var i = 0; i < categories.length; i++) {
    var opt = document.createElement("option");
    opt.value = categories[i].id;
    opt.innerHTML = categories[i].category;
    select.appendChild(opt);
  }
};

const deleteCategory = (event) => {
  if (confirm("Are you sure to delete?")) {
    $.ajax({
      type: "POST",
      url: "./action.php",
      data: { id: $(event.target).attr("id"), action: "delete" },
      beforeSend: () => alert("Deleting"),
      success: (res) => {
        if (res == "false") {
          alert("Delete SubCategories");
        } else {
          fetch();
          alert("Deleted");
        }
      },
    });
  }
};

const editCategory = (event, categories) => {
  console.log(categories);
  const id = $(event.target).attr("id");
  const row = $(event.target).attr("data-row");

  $("#id").val(id);
  $("#action").val("edit");
  $("#btn").html("Edit");

  $("#category").val(categories[row].category);
  $("#parent").val(categories[row].parent);
};

const tableValues = (categories) => {
  var col = [];
  for (var i = 0; i < categories.length; i++) {
    for (var key in categories[i]) {
      if (col.indexOf(key) === -1) {
        col.push(key);
      }
    }
  }
  var table = document.createElement("table");
  table.setAttribute("class", "table");
  var tr = table.insertRow(-1);
  var th = document.createElement("th");
  th.innerHTML = "Id";
  tr.appendChild(th);
  th = document.createElement("th");
  th.innerHTML = "Category";
  tr.appendChild(th);
  th = document.createElement("th");
  th.innerHTML = "Delete";
  tr.appendChild(th);
  th = document.createElement("th");
  th.innerHTML = "Edit";
  tr.appendChild(th);

  for (var i = 0; i < categories.length; i++) {
    tr = table.insertRow(-1);
    for (var j = 0; j < 2; j++) {
      var tabCell = tr.insertCell(-1);
      if (j == 1) {
        hierarchy = "";
        for (var k = 0; k < categories[i][col[j + 2]]; k++) {
          hierarchy += "-";
        }
        tabCell.innerHTML = `${hierarchy} ${categories[i][col[j]]}`;

        td = tr.insertCell(-1);
        delBtn = document.createElement("button");
        delBtn.setAttribute("class", "btn");
        delBtn.setAttribute("class", "btn-danger");
        delBtn.setAttribute("id", categories[i][col[0]]);
        delBtn.innerHTML = "Delete";
        delBtn.addEventListener("click", (event) => deleteCategory(event));
        td.appendChild(delBtn);

        td = tr.insertCell(-1);
        editBtn = document.createElement("button");
        editBtn.setAttribute("class", "btn");
        editBtn.setAttribute("class", "btn-warning");
        editBtn.setAttribute("id", categories[i][col[0]]);
        editBtn.setAttribute("data-row", i);
        editBtn.innerHTML = "Edit";
        editBtn.addEventListener("click", (event) =>
          editCategory(event, categories)
        );
        td.appendChild(editBtn);
      } else {
        tabCell.innerHTML = categories[i][col[j]];
      }
    }
  }
  var divContainer = document.getElementById("table");
  divContainer.innerHTML = "";
  divContainer.appendChild(table);
};

fetch();
