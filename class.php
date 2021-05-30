<?php

class User
{
//プロパティの宣言
public function get_user(){
try {
$dbh = dbConnect();
$sql = "SELECT id,name,password,profile,image
FROM user
WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(':id' => 0));
return $stmt->fetch();
} catch (\Exception $e) {
error_log('エラー発生:' . $e->getMessage());
set_flash('error',ERR_MSG1);
}
}

//インスタンスの生成
$user = new User();

echo $user->get_user();
?>