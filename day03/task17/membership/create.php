<?php

require "../config.php";
require "../nav.php";


$error = "";


$members = $pdo->query(
    "SELECT id, first_name, last_name
     FROM members"
)->fetchAll(PDO::FETCH_ASSOC);



$plans = $pdo->query(
    "SELECT id, name
     FROM membership_plans"
)->fetchAll(PDO::FETCH_ASSOC);




if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $member_id = $_POST['member_id'];
    $membership_plan_id = $_POST['membership_plan_id'];
    $start_date = $_POST['start_date'];



    if (empty($member_id)) {


        $error = "Please select member.";



    } elseif (empty($membership_plan_id)) {


        $error = "Please select membership plan.";



    } elseif (empty($start_date)) {


        $error = "Please select start date.";



    } else {



        $stmt = $pdo->prepare(
            "SELECT duration_days, visits_limit
             FROM membership_plans
             WHERE id = ?"
        );



        $stmt->execute([
            $membership_plan_id
        ]);



        $plan = $stmt->fetch(PDO::FETCH_ASSOC);



        if (!$plan) {


            $error = "Invalid membership plan.";



        } else {



            $endDate = date(
                'Y-m-d',
                strtotime(
                    $start_date . " + " . $plan['duration_days'] . " days"
                )
            );



            $stmt = $pdo->prepare(
                "INSERT INTO memberships
                (
                    member_id,
                    membership_plan_id,
                    start_date,
                    end_date,
                    remaining_visits,
                    status
                )

                VALUES (?, ?, ?, ?, ?, 'active')"
            );



            $stmt->execute([
                $member_id,
                $membership_plan_id,
                $start_date,
                $endDate,
                $plan['visits_limit']
            ]);



            header("Location: index.php");
            exit;

        }

    }

}


?>



<h1>Create Membership</h1>



<?php if ($error): ?>

    <p>
        <?= $error ?>
    </p>

<?php endif; ?>



<form method="POST">



    <label>
        Member:
    </label>


    <select name="member_id">


        <option value="">
            Select member
        </option>



        <?php foreach ($members as $member): ?>


            <option value="<?= $member['id'] ?>" <?= isset($_POST['member_id']) && $_POST['member_id'] == $member['id'] ? 'selected' : '' ?>>


                <?= $member['first_name'] ?>
                <?= $member['last_name'] ?>


            </option>



        <?php endforeach; ?>


    </select>



    <br><br>




    <label>
        Plan:
    </label>



    <select name="membership_plan_id">



        <option value="">
            Select plan
        </option>



        <?php foreach ($plans as $plan): ?>


            <option value="<?= $plan['id'] ?>" <?= isset($_POST['membership_plan_id']) && $_POST['membership_plan_id'] == $plan['id'] ? 'selected' : '' ?>>


                <?= $plan['name'] ?>


            </option>



        <?php endforeach; ?>



    </select>



    <br><br>




    <label>
        Start date:
    </label>


    <input type="date" name="start_date" value="<?= $_POST['start_date'] ?? '' ?>">



    <br><br>



    <button type="submit">
        Create
    </button>



</form>