const axios = require("axios");
const { config } = require("../../../../config");

const fetch = axios.create({
  baseURL: config.ocisUrl,
});

const fileList = [];

function getAdminAuthHeader() {
  return {
    Authorization: "Basic " + Buffer.from("admin:admin").toString("base64"),
  };
}

async function createFolder(folderName) {
  fileList.push(folderName);
  return await fetch({
    url: `/dav/files/admin/${folderName}`,
    method: "MKCOL",
    headers: getAdminAuthHeader(),
  });
}

async function deleteFolder() {
  for (value of fileList) {
    await fetch.delete(`/dav/files/admin/${value}`, {
      headers: getAdminAuthHeader(),
    });
  }
}

module.exports = { createFolder, deleteFolder };
