import { onMounted, reactive } from "vue";

const oEvidencia = reactive({
    id: 0,
    codigo: "",
    descripcion: "",
    nombre_creador: "",
    fecha_creacion: "",
    hora_creacion: "",
    origen_archivo: "",
    fecha_hallazgo: "",
    hora_hallazgo: "",
    lugar_recoleccion: "",
    persona_recolector: "",
    herramienta_utilizada: "",
    archivos: [],
    eliminados: [],
    _method: "POST",
});

export const useEvidencias = () => {
    const setEvidencia = (item = null) => {
        if (item) {
            oEvidencia.id = item.id;
            oEvidencia.codigo = item.codigo;
            oEvidencia.descripcion = item.descripcion;
            oEvidencia.nombre_creador = item.nombre_creador;
            oEvidencia.fecha_creacion = item.fecha_creacion;
            oEvidencia.hora_creacion = item.hora_creacion;
            oEvidencia.origen_archivo = item.origen_archivo;
            oEvidencia.fecha_hallazgo = item.fecha_hallazgo;
            oEvidencia.hora_hallazgo = item.hora_hallazgo;
            oEvidencia.lugar_recoleccion = item.lugar_recoleccion;
            oEvidencia.persona_recolector = item.persona_recolector;
            oEvidencia.herramienta_utilizada = item.herramienta_utilizada;
            oEvidencia.archivos = item.archivos;
            oEvidencia.eliminados = [];
            oEvidencia._method = "PUT";
            return oEvidencia;
        }
        return false;
    };

    const limpiarEvidencia = () => {
        oEvidencia.id = 0;
        oEvidencia.codigo = "";
        oEvidencia.descripcion = "";
        oEvidencia.nombre_creador = "";
        oEvidencia.fecha_creacion = "";
        oEvidencia.hora_creacion = "";
        oEvidencia.origen_archivo = "";
        oEvidencia.fecha_hallazgo = "";
        oEvidencia.hora_hallazgo = "";
        oEvidencia.lugar_recoleccion = "";
        oEvidencia.persona_recolector = "";
        oEvidencia.herramienta_utilizadacodigo = "";
        oEvidencia.descripcion = "";
        oEvidencia.nombre_creador = "";
        oEvidencia.fecha_creacion = "";
        oEvidencia.hora_creacion = "";
        oEvidencia.origen_archivo = "";
        oEvidencia.fecha_hallazgo = "";
        oEvidencia.hora_hallazgo = "";
        oEvidencia.lugar_recoleccion = "";
        oEvidencia.persona_recolector = "";
        oEvidencia.herramienta_utilizada = "";
        oEvidencia.archivos = [];
        oEvidencia.eliminados = [];
        oEvidencia._method = "POST";
    };

    onMounted(() => {});

    return {
        oEvidencia,
        setEvidencia,
        limpiarEvidencia,
    };
};
