<?php
class Product
{
  public $id;
  public $title;
  public $author;
  public $price;
  public $description;
  public $cover_url;
  public $is_best_seller;

  public function findPageAll($conexion, $limit, $offset, $isBestSeller = null)
  {
    $products = [];
    if ($isBestSeller === null) {
      $stmt = $conexion->prepare("SELECT * FROM product LIMIT ? OFFSET ?");
      $stmt->bind_param("ii", $limit, $offset);
    } else {
      $stmt = $conexion->prepare("SELECT * FROM product WHERE is_best_seller = ? LIMIT ? OFFSET ?");
      $stmt->bind_param("iii", $isBestSeller, $limit, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $product = new Product();
      $product->id = $row["id"];
      $product->title = $row["title"];
      $product->author = $row["author"];
      $product->price = $row["price"];
      $product->description = $row["description"];
      $product->cover_url = $row["cover_url"];
      $product->is_best_seller = $row["is_best_seller"];
      $products[] = $product;
    }

    return $products;
  }

  public function countPages($conexion, $perPage)
  {
    $query = "SELECT COUNT(*) as total FROM product";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
    return ceil($total / $perPage);
  }
}
