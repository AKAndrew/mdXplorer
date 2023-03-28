"use strict";

import axios from "axios";

const basePath = `http://localhost:8009`;

export const sendCmd = function (command) {
  axios({
    method: "post",
    baseURL: basePath,
    url: "/command",
    data: {
      cmd: command,
    },
  })
    .then((response) => {
      console.log(response);
    })
    .catch((error) => {
      console.log(error);
    });
};

//sendCmd(cmd);
