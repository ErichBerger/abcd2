<?php 
/*********************************************************************************/
//Code for getting info from OpenAI API
$message = null;
$result = null;

if(!isset($_SESSION['log'])) {
    
    $_SESSION['log'] = array();
}

if(isset($_POST['input'])) {
    if(sizeof($_SESSION['log']) > 6) {
        $_SESSION['log'] = array_slice($_SESSION['log'], -6);
    }
    $message = $_POST['input'];
    $_SESSION['log'][] = $message;
    $headers = [
        'Content-Type: application/json',
         //Change the sequence of characters to a key optained from open ai.
        //https://openai.com/blog/openai-api
        'Authorization: Bearer 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'
    ];

    $alt = ["model" => "gpt-4", 
        "messages" => [
            ["role" => "system", "content" => "Please limit responses to 1000 characters or fewer. Reply with How can I help? if no question is asked."], 
            ["role" => "user", "content" => $message]]];
    $alt = json_encode($alt);

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => 2,
        CURLOPT_POSTFIELDS => $alt
    ]);
    
    $response = (json_decode(curl_exec($ch), true))['choices'][0]['message']['content'];
    curl_close($ch);
    
    $_SESSION['log'][] = $response;
    
    
    /************************************************************************************/
    
}
?>
<style>
#bot {
    text-align: center;
    margin: auto;
    border-style: solid;
    border-radius: 0.5rem;
    padding: 1rem;
    width: 40vw;
    font-family: verdana, sans-serif;
    background-color: #FAF9F6;
    color: #000e34;
    font-size: 1rem;
}

.bot div {
    padding: 0.5rem;
}
.bot-title {
    text-align: center;
    font-size: 2rem;
}
.bot-text {
    font-size: 0.75rem;
}
.bot-message {
    border: 1px solid;
    padding: 0.25rem;
    border-radius: 0.5rem;
    margin-top: 0.25rem;
    overflow-anchor: none;
    width: fit-content;
}
.bot-history {
    max-height: 30vh;
    overflow-y: auto;
    scroll-behavior: smooth;
    display: flex;
    flex-direction: column;
 
    margin-bottom: 1rem;
    
}

#anchor {
    overflow-anchor: auto;
    height: 1px;
}

#right {
    margin-left: 4rem;
    
    text-align: left;
    background-color: lightblue;
}

#left {
    margin-right: 4rem;
    text-align: left;
}

</style>

<div id="bot">
<div class="bot-title">A Bot Chatting on Dresses</div>
<div class="bot-history" >
<?php 
    if(isset($_SESSION['log'])) {
        $log = $_SESSION['log'];
        for ($i = 0; $i < sizeof($log); $i++) {
            if ($i % 2 == 0) {
                echo '<div class="bot-message" id="right">'.$log[$i]."</div>";
            }
            else {
                echo '<div class="bot-message" id="left">'.$log[$i]."</div>";
            }
        }
       
    }
?>
<div id="anchor"></div>
</div>
<form action="chat.php" method="post"> <!-- change the action to whatever page you want it to be displayed on -->
    <input type="text" name="input" id="input" placeholder="Enter your question here.">
    <input type="submit">
</form>


<div class="bot-text">This might take awhile, please wait until the page is finished loading to enter a new prompt.</div>
</div>