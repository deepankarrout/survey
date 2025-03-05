1. Login API:
-------------
API: "https: //bgvsodisha.org/survey/api/login.php"
Method: POST
Request Format: JSON
Request Payload: {
    "username": "surveyor",
    "password": "Password@xyz"
}
Sample Successfull Response: {
    "response": "SUCCESS",
    "message": "Successfully logged In.",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2OTg0ODgwNzAsImV4cCI6MTY5ODQ5MTY3MCwiaXNzIjoiaHR0cHM6Ly9iZ3Zzb2Rpc2hhLm9yZy9zdXJ2ZXkvIiwiZGF0YSI6eyJpZCI6IjEiLCJ1c2VyX25hbWUiOiJzdXJ2ZXlvciIsIm5hbWUiOiJUZXN0IFN1cnZleW9yIiwiZW1haWwiOiJzdXJldmV5b3JAZ21haWwuY29tIiwicGhvbmUiOiI4MDkzNDU3MzQ1In19.0sK86KBKCRTBdyP_TxKVpjWoLlH3pQXivmaBdPvLKVk",
    "status": "200"
}

2. Get Question Lists:
---------------------
API: "https: //bgvsodisha.org/survey/api/getQuestions.php"
Method: POST
Request Format: JSON
Request Payload: {
    //After sucessfull login genrated token will be passed here
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2OTg0ODQzMTcsImV4cCI6MTY5ODQ4NzkxNywiaXNzIjoiaHR0cHM6Ly9iZ3Zzb2Rpc2hhLm9yZy9zdXJ2ZXkvIiwiZGF0YSI6eyJpZCI6IjEiLCJ1c2VyX25hbWUiOiJzdXJ2ZXlvciIsIm5hbWUiOiJUZXN0IFN1cnZleW9yIiwiZW1haWwiOiJzdXJldmV5b3JAZ21haWwuY29tIiwicGhvbmUiOiI4MDkzNDU3MzQ1In19.WVLHiPiwAnr-enQl8618j6UnM0uzd6PzTeJ4o94e-nw"
}
Sample Successfull Response: {
    "response": "SUCCESS",
    "message": "Access granted !",
    "token": "",
    "status": "200",
    "data": [
        {
            "question_bit": "1",
            "question": "District",
            "question_type": "Dropdown",
            "is_required": "1"
        },
        {
            "question_bit": "2",
            "question": "Block",
            "question_type": "Dropdown",
            "is_required": "1"
        },
        {
            "...."
        },
        {
            "...."
        },
    ]
}

3. Submit Survey Data:
----------------------
API: "https: //bgvsodisha.org/survey/api/postSurveyData.php"
Method: POST
Request Format: JSON
Request Payload: {
     //After sucessfull login genrated token will be passed here
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2OTg0ODgwNzAsImV4cCI6MTY5ODQ5MTY3MCwiaXNzIjoiaHR0cHM6Ly9iZ3Zzb2Rpc2hhLm9yZy9zdXJ2ZXkvIiwiZGF0YSI6eyJpZCI6IjEiLCJ1c2VyX25hbWUiOiJzdXJ2ZXlvciIsIm5hbWUiOiJUZXN0IFN1cnZleW9yIiwiZW1haWwiOiJzdXJldmV5b3JAZ21haWwuY29tIiwicGhvbmUiOiI4MDkzNDU3MzQ1In19.0sK86KBKCRTBdyP_TxKVpjWoLlH3pQXivmaBdPvLKVk",
    "qn_1": "Test",
    "qn_2": "Test",
    "qn_3": "Test",
    "qn_4": "xxxxxx",
    "qn_5": "xxxx",
    "qn_6": "8347834788",
    "qn_7": "xxx xxxx",
    "qn_8": "Yes",
    "qn_9": "No",
    "qn_10": "Yes",
    "qn_11": "No",
    "qn_12": "Yes",
    "qn_13": "Yes",
    "qn_14": "No",
    "qn_15": "No",
    "qn_16": "No",
    "qn_17": "No",
    "qn_18": "Yes",
    "qn_19": "No",
    "qn_20": "No"
}
Sample Successfull Response: {
    "response": "SUCCESS",
    "message": "Sucessfully Submitted !",
    "token": "",
    "status": "200"
}