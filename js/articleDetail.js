async function getResult() {
  const query = await fetch(
    "https://scrapperkf.herokuapp.com/php/Api/getDataForOneArticle.php",
    {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        href:new URLSearchParams(location.search).get("/articleHref")
      })
    }
  );
  return query;
}

const res = await getResult();
const products = await res.json();
const tbody = document.getElementsByTagName("tbody")[0];
const noOfProducts = products.result.length;

console.log(products);

function fillTableWithData() {
  for (let index = 0; index < noOfProducts; index++) {
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
          '<p style="text-decoration: line-through">' +
          products["result"][index][ind] +
          "</p>";
        newRow.appendChild(newCell);
      } else if (ind == 4) {
        newCell.innerHTML =
          "<a href=" + products["result"][index][ind] + "> Link </a>";
        newRow.appendChild(newCell);
      } else {
        newCell.innerHTML = products["result"][index][ind];
        newRow.appendChild(newCell);
      }
    }
  }
}

fillTableWithData();
