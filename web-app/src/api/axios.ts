import Axios from "axios";

function getCookie(param: string) {
  let cookie = document.cookie.split("; ").find(item => item.startsWith(`${param}=`));

  if (!cookie) {
    return null;
  }
  return decodeURIComponent(cookie.split("=")[1]);
}

const axios = Axios.create({
  baseURL: "http://localhost:8000",
  // baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true,
  headers: {
    Accept: "application/json",
  },
});

axios.interceptors.request.use(async req => {
    const storageVal = window.localStorage.getItem('token');
    let token = ''
    if (storageVal) {
        token = JSON.parse(storageVal);
    }
    //   if (req.method === "get") {
    //     return req;
    //   }

    //   let csrfToken = getCookie("XSRF-TOKEN");

    //   if (!csrfToken) {
    //     await axios.get("/sanctum/csrf-cookie");
    //     csrfToken = getCookie("XSRF-TOKEN");
    //   }
    req.headers.Authorization = `Bearer ${token}`
    //   req.headers["Authorization"] = csrfToken;
    return req;
});

export default axios;