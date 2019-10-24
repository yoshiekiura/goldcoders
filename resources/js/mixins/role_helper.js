export default {
    methods: {
        checkIfMemberOnly() {
            if (!this.$page.auth.user.roles.includes("paymaster", "admin")) {
                return true;
            } else {
                return false;
            }
        }
    }
};
