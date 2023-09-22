<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css" />
    <title>Lista de Usuários</title>
</head>
<body>
    <div id="interface">
        <fieldset>
            <legend>.::Lista de Usuário::.</legend>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Idade</th>
                    <th>Sexo</th>
                    <th>Estado Civil</th>
                    <th>Humanas</th>
                    <th>Exatas</th>
                    <th>Biológicas</th>
                    <th>Hash da Senha</th>
                </tr>

                <?php
                    try {
                        $conn = new PDO('mysql:host=localhost;dbname=cadastro', 'root', '');
                        $conn->exec("set names utf8");
                    } catch(PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                        exit();
                    }

                    // rotina de exclusão
                    if(isset($_REQUEST["excluir"]) && $_REQUEST["excluir"] == true) {
                        $sql = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
                        $sql->bindParam(1, $_REQUEST["id"]);
                        $sql->execute();

                        if($sql->errorCode() != "00000") {
                            echo "Erro código " . $sql->errorCode() . ": ";
                            echo implode(", ", $sql->errorInfo());
                        }
                    }

                    $sql = $conn->prepare("SELECT * FROM usuarios");
                    if($sql->execute()) {
                        while($registro = $sql->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                                echo "<td>".$registro->nome."</td>";
                                echo "<td>".$registro->email."</td>";
                                echo "<td>".$registro->idade."</td>";
                                echo "<td>".$registro->sexo."</td>";
                                echo "<td>".$registro->estado_civil."</td>";
                                echo "<td>".$registro->humanas."</td>";
                                echo "<td>".$registro->exatas."</td>";
                                echo "<td>".$registro->biologicas."</td>";
                                echo "<td>".$registro->senha."</td>";

                                echo "<td>";
                                echo "<a href='?excluir=true&id=".$registro->id."'> Excluir</a> |";
                                echo "<a href='aula_alterar.php?id=".$registro->id."'> Alterar</a> |";
                                echo "<a href='aula_senha.php?id=".$registro->id."'> Alterar Senha</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Falha na seleção dos usuários<br>";
                    }
                ?>
            </table>
        </fieldset>

        <p class="link"><a href="aula_menu.php">Menu Principal</a></p>
    </div>
</body>
</html>