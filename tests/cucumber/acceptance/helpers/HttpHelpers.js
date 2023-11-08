const axios = require('axios');
const {create} = require("axios");

const fetch = axios.create({
        baseURL: 'https://host.docker.internal:9200',
})

function getAdminAuthHeader(){
    return {
        Authorization: 'Basic ' + Buffer.from('admin:admin').toString('base64')
    }
}
async function createFolder(folderName){
    return await fetch({
        url: `/dav/files/admin/${folderName}`,
        method: 'MKCOL',
        headers: getAdminAuthHeader(),
    })
}

async function getResources(){
    const listOfResources = await fetch.get()
}
async function deleteFolder() {
    await fetch.delete(`/dav/files/admin/test`,{
        headers:getAdminAuthHeader()}
    );
}

module.exports = {createFolder};