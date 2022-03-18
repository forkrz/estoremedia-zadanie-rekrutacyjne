async function getResult() {
  const query = await fetch("https://scrapperkf.herokuapp.com/php/Api/getData.php", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
  });
  return query;
}

const res = await getResult();
const products = await res.json();
const tbody = document.getElementsByTagName("tbody")[0];

function pagin(page) {
  const noOfProducts = products.result.length;
  const numberPerPage = 14;
  const numberOfPages = Math.ceil(noOfProducts / numberPerPage);
  const minPagin = (page - 1) * numberPerPage;
  if (minPagin + numberPerPage > noOfProducts) {
    const maxPagin = noOfProducts;
    return [minPagin, maxPagin, numberOfPages];
  }else{
    const maxPagin = minPagin + numberPerPage;
    return [minPagin, maxPagin, numberOfPages];
  }
    

}

function fillTableWithData(page) {
  for (let index = pagin(page)[0]; index < pagin(page)[1]; index++) {
    let newRow = tbody.insertRow();
    for (let ind = 0; ind < 7; ind++) {
      let newCell = newRow.insertCell();
      if (ind == 0) {
        if (products["result"][index][ind].length > 10) {
          newCell.innerHTML =
            products["result"][index][ind].substring(0, 12) + "...";
          newRow.appendChild(newCell);
        }
      } else if (ind == 1) {
        newCell.innerHTML =
          "<a href=" +
          products["result"][index][ind] +
          "> Link </a>";
        newRow.appendChild(newCell);
      } else if (ind == 2) {
        newCell.innerHTML =
          "<a href=" + products["result"][index][ind] + "> Link </a>";
        newRow.appendChild(newCell);
      } else if (ind == 6){
        newCell.innerHTML = "<a href=http://barcode.loc/articleDetail.html?/articleHref=" + products["result"][index][1] + "> Link </a>";
        newRow.appendChild(newCell);
      }else {
        newCell.innerHTML = products["result"][index][ind];
        newRow.appendChild(newCell);
      }
    }
  }
}

function paginationAddEventListeners(i) {
  fillTableWithData(i);
  document.getElementById("previous").addEventListener("click", (e) => {
    e.preventDefault();
    if (i == 1) {
      return;
    } else {
      i--;
      tbody.innerHTML = "";
      fillTableWithData(i);
      console.log(i);
    }
  });
  document.getElementById("next").addEventListener("click", (e) => {
    e.preventDefault();
    if (i >= pagin(i)[2]) {
      return;
    } else {
        i++;
      tbody.innerHTML = "";
    fillTableWithData(i);
    }
  });
  
}
paginationAddEventListeners(1);
