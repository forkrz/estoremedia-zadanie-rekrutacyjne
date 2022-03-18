async function getResult() {
  const query = await fetch(
    "http://barcode.loc/php/Api/getDataForOneArticle.php",
    {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: new URLSearchParams(location.search).get("/articleHref"),
    }
  );
  return query;
}

const res = await getResult();
const products = await res.json();

console.log(res);