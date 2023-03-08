let form=document.getElementById('form')

function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

let socket_url='ws://localhost:8080'
    let ws=new WebSocket(socket_url)

    ws.onmessage=(event)=>{
        data=event.data
        if(!isJsonString(data)){
            return 
        }
        // if(!data){return }
        data=JSON.parse(data)
        console.log(data);


    }


form.onsubmit=(e)=>{
    e.preventDefault()
    // console.log(e);
    let elements=e.target.elements
    let dt={
        id:elements['id'].value,
       type:"setId"
    }
    console.log(dt);
    ws.send(JSON.stringify(dt))
    

}