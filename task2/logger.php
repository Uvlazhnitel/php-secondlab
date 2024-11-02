<?php
// Define a Logger class to handle logging of information.
class Logger
{
    // Private properties to store the client IP, the query string, and the path to the log file.
    private string $ip;
    private string $queryString;
    private string $logPath;

    // Constructor method for the Logger class.
    // It initializes the object with the path to the log file and captures the client IP and query string from the server environment.
    public function __construct($logPath){
        // Retrieve the client IP address from the server environment variables.
        $this->ip = $_SERVER['REMOTE_ADDR'];
        // Retrieve the query string from the server environment variables.
        $this->queryString = $_SERVER['QUERY_STRING'];
        // Set the path to the log file based on the constructor parameter.
        $this->logPath = $logPath;
    }

    // Protected method to generate a formatted log entry.
    // It takes a result parameter and returns a string formatted with the client IP, current date, query string, and the result.
    protected function generateLine($result){
        // Get the current date and time in the ISO 8601 format.
        $date = date('c');
        // Return a formatted string combining IP, date, query string, and result, separated by brackets.
        return sprintf("[%s][%s][%s][%s]\n",
                       $this->ip, $date, $this->queryString, $result);
    }

    // Public method to log information to the log file.
    // It takes a result parameter, generates a log entry using `generateLine`, and appends it to the log file.
    public function log($result){
        // Append the generated log entry to the log file specified by $this->logPath.
        file_put_contents($this->logPath,
                          $this->generateLine($result), FILE_APPEND);
    }
}
?>
