import { onMounted, ref } from "vue";

const oCadenaCustodia = ref({
    id: 0,
    evidencia_id: "",
    responsable: "",
    cargo: "",
    accion: "",
    destino: "",
    fecha: "",
    hora: "",
    observaciones: "",
    _method: "POST",
});

export const useCadenaCustodias = () => {
    const setCadenaCustodia = (item = null) => {
        if (item) {
            oCadenaCustodia.value.id = item.id;
            oCadenaCustodia.value.evidencia_id = item.evidencia_id;
            oCadenaCustodia.value.responsable = item.responsable;
            oCadenaCustodia.value.cargo = item.cargo;
            oCadenaCustodia.value.accion = item.accion;
            oCadenaCustodia.value.destino = item.destino;
            oCadenaCustodia.value.fecha = item.fecha;
            oCadenaCustodia.value.hora = item.hora;
            oCadenaCustodia.value.observaciones = item.observaciones;
            oCadenaCustodia.value._method = "PUT";
            return oCadenaCustodia;
        }
        return false;
    };

    const limpiarCadenaCustodia = () => {
        oCadenaCustodia.value.id = 0;
        oCadenaCustodia.value.evidencia_id = "";
        oCadenaCustodia.value.responsable = "";
        oCadenaCustodia.value.cargo = "";
        oCadenaCustodia.value.accion = "";
        oCadenaCustodia.value.destino = "";
        oCadenaCustodia.value.fecha = "";
        oCadenaCustodia.value.hora = "";
        oCadenaCustodia.value.observaciones = "";
        oCadenaCustodia.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oCadenaCustodia,
        setCadenaCustodia,
        limpiarCadenaCustodia,
    };
};
