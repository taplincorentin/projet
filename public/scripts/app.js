//chercher la liste de race de dog.ceo api
async function start(){
    const reponse = await fetch("https://dog.ceo/api/breeds/list/all")
    const data = await reponse.json()
    creationListeRaces(data.message)
}

start()

//création du menu déroulant à partir de la liste de races
function creationListeRaces(listeRaces){

    document.getElementById("race").innerHTML = `
        <select>
            <option>Choose a breed</option>
            ${Object.keys(listeRaces).map(function (race){
                return `<option>${race}</option>`
                }).join('')}
            }
        </select>
    `
}


// function selectRace(race){
//     if (race != "Choose a breed") {

//     }
// }