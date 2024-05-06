import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        counter: 100,
        deleteModulObj: {
            showDeleteModul: false,
            deleteUrl: "",
            data: null
        },
        deleteInf: {
            isDeleting: false,
            deletingIndex: -1
        },
        user:false,
        userPermission:null,
    },
    getters: {
        getDeleteObj(state) {
            return state.deleteModulObj;
        },
        getDeleteInf(state) {
            return state.deleteInf;
        },
        getUserPermission(state){
            return state.userPermission;
        }
    },
    mutations: {
        setDeleteModul(state, data) {
            state.deleteModulObj.showDeleteModul = data;
        },
        setDeleteInf(state, payload) {
            console.log(payload.deletingIndex);
            const deleteInf = {
                isDeleting: payload.isDeleting,
                deletingIndex: payload.deletingIndex
            };
            state.deleteInf = deleteInf;
            //state.deleteInf.deletingIndex=payload.deletingIndex;
            //state.deleteInf.isDeleting=payload.isDeleting;
        },
        setDeletingModulObj(state, data) {
            state.deleteModulObj = data;
        },
        setContents(state, data) {
            state.contents = data;
        },
        setUpdateUser(state,data){
            state.user=data;
        },
        setUserPermission(state,data){
            state.userPermission=data;
        }
    }
});
export default store;
/* console.log(payload)
const deleteModulObj={
    showDeleteModul:payload[data1].showDeleteModul,
    deleteUrl:payload[data1].deleteUrl,
    data:payload[data1].data,
    isDeleting:payload[data2],
    deletingIndex:payload[data1].deletingIndex
}*/
