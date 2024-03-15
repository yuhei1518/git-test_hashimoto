<?php
session_start();
require('date.php');

if (!empty($_POST)) {
    $error = [];

    if ($_POST['name'] == "") {
        $error['name'] = 'blank';
    }

    if ($_POST['mail'] == "") {
        $error['mail'] = 'blank';
    }

    if ($_POST['coment'] == "") {
        $error['coment'] = 'blank';
    }

    if ($_POST['subject'] == "") {
        $error['subject'] = 'blank';
    }

    if (empty($error)) {
        try {

            $statement = $pdo->prepare('INSERT INTO comments (name, mail, coment, subject) VALUES (:name, :mail, :coment, :subject)');
            $statement->execute(array(
                ':name' => $_POST['name'],
                ':mail' => $_POST['mail'],
                ':coment' => $_POST['coment'],
                ':subject' => $_POST['subject'],
            ));

            header('Location: kadai.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>Git・PHP・SQL テスト課題</title>
    <link rel="stylesheet" href="kadai.css">
    <script src="js/particles.js"></script>
</head>

<body>

    <div class="header">
        <h1>Git・PHP・SQL テスト課題</h1>
    </div>

    <div class="main">
        <div class="profile">
            <img src="images/1.jpg" alt="">
        </div>

        <div class="self">
            <h2>アニメしか勝たん！未だに少年心全開の橋本悠平29歳♡</h2>
        </div>
    </div>

        <div class="segi1">
          <ul><br>
            <li><strong>名前:</strong> 瀬木　和憲</li>
            <li><strong>生年月日:</strong> 1972年5月23日</li>
            <li><strong>住所:</strong> 三重県松阪市</li>
            <li><strong>好きなもの:</strong>サッカー観戦・ドライブ・スズメ（小鳥）</li><br>
          </ul>
        </div>
        <div class="segi2">自己紹介<br>
          <p>もともとプロセス（工法）開発系のお仕事をしてました。<br>
            複雑な製品になると担当分野が狭くなりがちなので、<br>
            自分で全体をみれるような開発業を探してきました。<br>
            今は自分でコードを完成できるようにしたいです。<br>
          </p>
        </div>
        </div>

    <div class="from">
        <form action="" method="post">
            ユーザー名：<br />
            <input type="text" name="name" size="30" value="" placeholder="例: 山田　太郎" /><br />
            <?php if (isset($error['name']) && ($error['name'] == "blank")) : ?>
                <p class="error">*ユーザー名おせ～て～</p>
            <?php endif; ?>
            メールアドレス：<br />
            <input type="text" name="mail" size="30" value="" placeholder="例: yuhei.1518@docomo.ne.jp" /><br />
            <?php if (isset($error['mail']) && ($error['mail'] == "blank")) : ?>
                <p class="error">*あんたのアドレスなんか興味ないんだからね</p>
            <?php endif; ?>
            コメント：<br />
            <textarea name="coment" cols="30" rows="5" placeholder="例: ええ感じに書いて"></textarea><br />
            <?php if (isset($error['coment']) && ($error['coment'] == "blank")) : ?>
                <p class="error">*コメントくれへんなんて寂しいわ～</p>
            <?php endif; ?>
            宛先：<br />
            <select name="subject" id="subject">
                <option value="hashimoto">橋本</option>
                <option value="segi">瀬木</option>
            </select><br><br>
            <input type="submit" value="登録する" />
        </form>

    </div>

    <div class="footer">
        <h3>こんなお問い合わせがあります</h3>
        <div class="footer-contents">
            <table border="1">
                <tr>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>コメント</th>
                </tr>
                <?php
                try {
                    $pdo = new PDO("mysql:host=localhost; dbname=git-test; charset=utf8", "root", "");
                    if (!$pdo) {
                        exit('データベースに接続できませんでした。');
                    }

                    $result = $pdo->query('SELECT * FROM comments ORDER BY time asc LIMIT 10');
                    if (!$result) {
                        exit('クエリの実行に失敗しました。');
                    }

                    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $data['name'] . "</td>";
                        echo "<td>" . $data['mail'] . "</td>";
                        echo "<td>" . $data['coment'] . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    exit('クエリの実行中にエラーが発生しました。エラー: ' . $e->getMessage());
                } finally {
                    $pdo = null;
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>