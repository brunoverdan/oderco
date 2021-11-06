import { http } from "./config";

export default{

    listar:()=>{
        return http.get('cotacao')
    },

    listarTransportadora:()=>{
        return http.get('transportadora')
    },

    salvar:(cotacao)=> {
        return http.post('cotacao', cotacao)
    },


    listarCalculo:(calcular)=> {
        return http.get('calcular', calcular)
    },

    Calcular:(calculo)=> {
        return http.put('cotacao', calculo)
    },

}
